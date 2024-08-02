<?php

namespace App\Http\Controllers\API\Tendik;

use Illuminate\Http\Request;
use App\Models\AcadStaffAnswer;
use Illuminate\Validation\Rule;
use App\Rules\AnswerWithinRange;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidAcadStaffQuestion;
use App\Models\AcadStaffQuestionnaire;
use App\Rules\AcadStaffAnswerWithinRange;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\DB; // Added this line
use App\Http\Resources\Tendik\AcadstaffAnswerResource;
use App\Http\Resources\Tendik\AcadStaffElementResource;
use App\Http\Resources\Tendik\AcadStaffQuestionnaireResource;

class AcadStaffQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acadstaffQuestionnaires = AcadStaffQuestionnaire::all();
        return $this->successResponse(AcadStaffQuestionnaireResource::collection($acadstaffQuestionnaires), 'Education Personal Questionnaires retrieved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acadstaffQuestionnaire = AcadStaffQuestionnaire::with('acadstaffElements.acadstaffQuestions')->find($id);
        if (is_null($acadstaffQuestionnaire)) {
            return $this->errorResponse('Education Personal Questionnaire not found', [], 404);
        }

        return $this->successResponse(new AcadStaffQuestionnaireResource($acadstaffQuestionnaire), 'Education Personal Questionnaire retrieved successfully');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fillQuestionAC(Request $request)
    {
        $acadstaffAnswer = AcadStaffAnswer::where('acad_staff_id', Auth::user()->id)
        ->where('acad_staff_questionnaire_id', $request->acad_staff_questionnaire['id'])
        ->first();

        if ($acadstaffAnswer) {
            return $this->errorResponse('You have filled the questionnaire', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'acad_staff_questionnaire.id' => 'required|integer|exists:acad_staff_questionnaires,id',
            'acad_staff_questionnaire.acad_staff_elements.*.id' => [
                'required',
                'integer',
                Rule::exists('acad_staff_elements', 'id')->where(function ($query) use ($request) {
                    return $query->where('acad_staff_questionnaire_id', $request->acad_staff_questionnaire['id']);
                }),
            ],
            'acad_staff_questionnaire.acad_staff_elements.*.acaf_staff_question.id.*' => [
                'required',
                'integer',
                new ValidAcadStaffQuestion($request),
            ],
            'acad_staff_questionnaire.acad_staff_elements.*.acad_staff_question.answer.*' => [
                'required',
                'integer',
                new AcadStaffAnswerWithinRange($request),
            ]
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }
        try {
            DB::beginTransaction();

            foreach ($request->acad_staff_questionnaire['acad_staff_elements'] as $element) {
                foreach ($element['acad_staff_question']['id'] as $index => $questionId) {
                    $answer = $element['acad_staff_question']['answer'][$index];
                    AcadStaffAnswer::create([
                        'answer' => $answer,
                        'acad_staff_id' => Auth::user()->id,
                        'acad_staff_questionnaire_id' => $request->acad_staff_questionnaire['id'],
                        'acad_staff_element_id' => $element['id'],
                        'acad_staff_question_id' => $questionId,
                    ]);
                }
            }

            DB::commit();

            $acadstaffAnswers = AcadStaffAnswer::where('acad_staff_id', Auth::user()->id)
                ->where('acad_staff_questionnaire_id', $request->acad_staff_questionnaire['id'])
                ->with('acadstaffQuestionnaire', 'acadstaffElement', 'acadstaffQuestion', 'acadstaff')
                ->get();

            if ($acadstaffAnswers->isEmpty()) {
                return response()->json([]);
            }

            $groupedAnswers = [
                'acad_staff_questionnaire' => $acadstaffAnswers->first()->acadstaffQuestionnaire->name,
                'acad_staff_name' => $acadstaffAnswers->first()->acadstaff->name,
                'answers' => $acadstaffAnswers->map(function ($item) {
                    return [
                        'acad_staff_element' => $item->acadstaffElement->name,
                        'acad_staff_question' => $item->acadstaffQuestion->question,
                        'answer' => $item->answer
                    ];
                })->toArray(),
                'created_at' => $acadstaffAnswers->first()->created_at,
            ];

            return $this->successResponse(new AcadstaffAnswerResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function showFilledQuestion($id)
    {
        $acadstaffAnswers = AcadStaffAnswer::where('acad_staff_id', Auth::user()->id)
            ->where('acad_staff_questionnaire_id', $id)
            ->with('acadstaffQuestionnaire', 'acadstaffElement', 'acadstaffQuestion', 'acadstaff')
            ->get();

        if ($acadstaffAnswers->isEmpty()) {
            return $this->errorResponse('Education Personal Answer AC not found', [], 404);
        }

        $groupedAnswers = [
            'acad_staff_questionnaire' => $acadstaffAnswers->first()->acadstaffQuestionnaire->name,
            'acad_staff_name' => $acadstaffAnswers->first()->acadstaff->name,
            'answers' => $acadstaffAnswers->map(function ($item) {
                return [
                    'acad_staff_element' => $item->acadstaffElement->name,
                    'acad_staff_question' => $item->acadstaffQuestion->question,
                    'answer' => $item->answer
                ];
            })->toArray(),
            'created_at' => $acadstaffAnswers->first()->created_at,
        ];

        return $this->successResponse(new AcadstaffAnswerResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
    }

}
