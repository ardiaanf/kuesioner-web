<?php

namespace App\Http\Controllers\API\Dosen;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dosen\LecturerAnswerResource;
use App\Http\Resources\Dosen\LecturerElementResource;
use App\Http\Resources\Dosen\LecturerQuestionnaireResource;
use App\Http\Resources\Dosen\LecturerQuestionResource;
use App\Models\LecturerAnswer;
use App\Models\LecturerQuestionnaire;
use App\Rules\LecturerAnswerWithinRange;
use App\Rules\ValidLecturerQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LecturerQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturerQuestionnaires = LecturerQuestionnaire::all();
        return $this->successResponse(LecturerQuestionnaireResource::collection($lecturerQuestionnaires), 'lecturer Questionnaires retrieved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lecturerQuestionnaire = LecturerQuestionnaire::with(['lecturerElements.lecturerQuestions'])->find($id);
        if (is_null($lecturerQuestionnaire)) {
            return $this->errorResponse('Lecturer Questionnaire not found', [], 404);
        }

        return $this->successResponse(new LecturerQuestionnaireResource($lecturerQuestionnaire), 'Lecturer Questionnaire retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function fillQuestion(Request $request)
     {
         $lecturerAnswer = LecturerAnswer::where('lecturer_id', Auth::user()->id)
             ->where('lecturer_questionnaire_id', $request->lecturer_questionnaire['id'])
             ->first();

         if ($lecturerAnswer) {
             return $this->errorResponse('You have filled the questionnaire', [], 400);
         }

         $validator = Validator::make($request->all(), [
             'lecturer_questionnaire.id' => 'required|integer|exists:lecturer_questionnaires,id',
             'lecturer_questionnaire.lecturer_elements.*.id' => [
                 'required',
                 'integer',
                 Rule::exists('lecturer_elements', 'id')->where(function ($query) use ($request) {
                     return $query->where('lecturer_questionnaire_id', $request->lecturer_questionnaire['id']);
                 }),
             ],
             'lecturer_questionnaire.lecturer_elements.*.lecturer_question.id.*' => [
                 'required',
                 'integer',
                 new ValidLecturerQuestion($request),
             ],
             'lecturer_questionnaire.lecturer_elements.*.lecturer_question.answer.*' => [
                 'required',
                 'integer',
                 new LecturerAnswerWithinRange($request),
             ]
         ]);

         if ($validator->fails()) {
             return $this->errorResponse('Validation Error', $validator->errors(), 422);
         }

         try {
             DB::beginTransaction();

             foreach ($request->lecturer_questionnaire['lecturer_elements'] as $element) {
                 foreach ($element['lecturer_question']['id'] as $index => $questionId) {
                     $answer = $element['lecturer_question']['answer'][$index];
                     LecturerAnswer::create([
                         'answer' => $answer,
                         'lecturer_id' => Auth::user()->id,
                         'lecturer_questionnaire_id' => $request->lecturer_questionnaire['id'],
                         'lecturer_element_id' => $element['id'],
                         'lecturer_question_id' => $questionId,
                     ]);
                 }
             }

             DB::commit();

             $lecturerAnswers = LecturerAnswer::where('lecturer_id', Auth::user()->id)
                 ->where('lecturer_questionnaire_id', $request->lecturer_questionnaire['id'])
                 ->with('lecturerQuestionnaire', 'lecturerElement', 'lecturerQuestion', 'lecturer')
                 ->get();

             if ($lecturerAnswers->isEmpty()) {
                 return response()->json([]);
             }

             $groupedAnswers = [
                 'lecturer_questionnaire' => $lecturerAnswers->first()->lecturerQuestionnaire->name,
                 'lecturer_name' => $lecturerAnswers->first()->lecturer->name,
                 'answers' => $lecturerAnswers->map(function ($item) {
                     return [
                         'lecturer_element' => $item->lecturerElement->name,
                         'lecturer_question' => $item->lecturerQuestion->question,
                         'answer' => $item->answer
                     ];
                 })->toArray(),
                 'created_at' => $lecturerAnswers->first()->created_at,
             ];

             return $this->successResponse(new LecturerAnswerResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
         } catch (\Exception $e) {
             DB::rollBack();
             return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
         }
     }

     public function showFilledQuestion($id)
     {
         $lecturerAnswers = LecturerAnswer::where('lecturer_id', Auth::user()->id)
             ->where('lecturer_questionnaire_id', $id)
             ->with('lecturerQuestionnaire', 'lecturerElement', 'lecturerQuestion', 'lecturer')
             ->get();

         if ($lecturerAnswers->isEmpty()) {
             return $this->errorResponse('Lecturer Answer AC not found', [], 404);
         }

         $groupedAnswers = [
             'lecturer_questionnaire' => $lecturerAnswers->first()->lecturerQuestionnaire->name,
             'lecturer_name' => $lecturerAnswers->first()->lecturer->name,
             'answers' => $lecturerAnswers->map(function ($item) {
                 return [
                     'lecturer_element' => $item->lecturerElement->name,
                     'lecturer_question' => $item->lecturerQuestion->question,
                     'answer' => $item->answer
                 ];
             })->toArray(),
             'created_at' => $lecturerAnswers->first()->created_at,
         ];

         return $this->successResponse(new LecturerAnswerResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
     }
}
