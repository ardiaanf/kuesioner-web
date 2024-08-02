<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AcadStaffQuestionnaireResource;
use App\Models\AcadStaff;
use App\Models\AcadStaffAnswer;
use App\Models\AcadStaffQuestionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AcadStaffQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //
        if (Auth::user()->role = 'admin') {
            $acadstaffQuestionnaires = AcadStaffQuestionnaire::with('admin')->get();
            return $this->successResponse(AcadStaffQuestionnaireResource::collection($acadstaffQuestionnaires), ' Education Personnel retrieved successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role = 'admin') {
            $input = $request->all();

            $validator = Validator::make(
                $input,
                [
                    'name' => 'required',
                    'description' => 'nullable',
                ]
            );

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            };

            $input['admin_id'] = Auth::user()->id;
            $acadstaffQuestionnaires = AcadStaffQuestionnaire::create($input);

            return $this->successResponse(new AcadStaffQuestionnaireResource($acadstaffQuestionnaires), 'Education Personnel Questionnaire created successfully', 201);
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->role == 'admin') {
            // $acadstaffQuestionnaires = AcadStaffQuestionnaire::find($id);
            $acadstaffQuestionnaires = AcadStaffQuestionnaire::with('admin')->find($id);
            if (is_null($acadstaffQuestionnaires)) {
                return $this->errorResponse('Education Personnel Questionnaire not found', [], 404);
            }

            return $this->successResponse(new AcadStaffQuestionnaireResource($acadstaffQuestionnaires), 'Education Personel Questionnaire retrieved successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Display the specified resource with relations.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithRelations($id)
    {
        if (Auth::user()->role == 'admin') {
            // $acadstaffQuestionnaire = LecturerQuestionnaire::with('lecturerElements.lecturerQuestions')->find($id);
            $acadstaffQuestionnaire = AcadStaffQuestionnaire::with('admin')->with('acadstaffElements.acadstaffQuestions')->find($id);
            if (is_null($acadstaffQuestionnaire)) {
                return $this->errorResponse('Education Personal Questionnaire not found', [], 404);
            }

            return $this->successResponse(new AcadStaffQuestionnaireResource($acadstaffQuestionnaire), 'Lecturer Questionnaire retrieved successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $acadstaffQuestionnaires = AcadStaffQuestionnaire::find($id);

            if (is_null($acadstaffQuestionnaires)) {
                return $this->errorResponse('Educational Personel Questionnaire not found', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $acadstaffQuestionnaires->name = $input['name'];
            $acadstaffQuestionnaires->description = $input['description'];
            $acadstaffQuestionnaires->save();

            return $this->successResponse(new AcadStaffQuestionnaireResource($acadstaffQuestionnaires), 'Education Personel Questionnaire updated successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $acadstaffQuestionnaire = AcadStaffQuestionnaire::find($id);

            if (is_null($acadstaffQuestionnaire)) {
                return $this->errorResponse('Education Personel Questionnaire not found', [], 404);
            }

            $acadstaffQuestionnaire->delete();

            return $this->successResponse([], 'Lecturer Questionnaire deleted successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    public function getFilledQuestionnaires()
    {
        if (Auth::user()->role != 'admin') {
            $acadstaff = AcadStaff::all();
            $acadstaff = $acadstaff->map(function ($acadstaff) {
                $acadstaffAnswers = AcadStaffAnswer::where('acad_staff_id', $acadstaff->id)
                    ->with('acadstaffQuestionnaire', 'acadstaffElement', 'acadstaffQuestion')
                    ->get();

                $acadstaff->filled = !$acadstaffAnswers->isEmpty();
                $acadstaff->acadstaffAnswers = $acadstaffAnswers;

                return $acadstaff;
            });

            $acadstaff = $acadstaff->filter(function ($acadstaff) {
                return $acadstaff->filled;
            });

            $groupedAnswers = $acadstaff->map(function ($acadstaff) {
                return [
                    'acad_staff_name' => $acadstaff->name,
                    'answers' => $acadstaff->acadstaffAnswers->map(function ($answer) {
                        return [
                            'acad_staff_questionnaire' => $answer->acadstaffQuestionnaire->name,
                            'acad_staff_element' => $answer->acadstaffElement->name,
                            'acad_staff_question' => $answer->acadstaffQuestion->question,
                            'answer' => $answer->answer,
                            'created_at' => $answer->created_at,
                        ];
                    }),
                ];
            });

            return $this->successResponse(
                $groupedAnswers,
                'Education Personal Questionnaires retrieved successfully'
            );
        }
        return $this->errorResponse('Unauthorized', [], 401);
    }
}
