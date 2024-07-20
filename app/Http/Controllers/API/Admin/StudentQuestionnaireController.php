<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentAnswerAc;
use App\Models\StudentAnswerTlp;
use App\Models\StudentQuestionnaire;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAnswerDetailTlp;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Admin\StudentAnswerACResource;
use App\Http\Resources\Admin\StudentQuestionnaireResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Admin\StudentQuestionnaireFilledResource;

class StudentQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            // $studentQuestionnaires = StudentQuestionnaire::all();
            $studentQuestionnaires = StudentQuestionnaire::with('admin')->get();
            return $this->successResponse(StudentQuestionnaireResource::collection($studentQuestionnaires), 'Student Questionnaires retrieved successfully');
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
        if (Auth::user()->role == 'admin') {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'type' => 'required|in:TLP,AC',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $input['admin_id'] = Auth::user()->id;
            $studentQuestionnaire = StudentQuestionnaire::create($input);

            return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire created successfully', 201);
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
            // $studentQuestionnaire = StudentQuestionnaire::find($id);
            $studentQuestionnaire = StudentQuestionnaire::with('admin')->find($id);
            if (is_null($studentQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire retrieved successfully');
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
            // $studentQuestionnaire = StudentQuestionnaire::with('studentElements.studentQuestions')->find($id);
            $studentQuestionnaire = StudentQuestionnaire::with('admin')->with('studentElements.studentQuestions')->find($id);
            if (is_null($studentQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire retrieved successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $studentQuestionnaire = StudentQuestionnaire::find($id);

            if (is_null($studentQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'type' => 'required|in:TLP,AC',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $studentQuestionnaire->name = $input['name'];
            $studentQuestionnaire->description = $input['description'];
            $studentQuestionnaire->type = $input['type'];
            $studentQuestionnaire->save();

            return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire updated successfully');
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
            $studentQuestionnaire = StudentQuestionnaire::find($id);

            if (is_null($studentQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            $studentQuestionnaire->delete();

            return $this->successResponse([], 'Student Questionnaire deleted successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    public function getFilledQuestionnaires()
    {
        if (Auth::user()->role == 'admin') {
            $students = Student::all();
            if (request()->query('type') == 'TLP') {
                $students = $students->map(function ($student) {
                    $studentAnswerDetailTlp = StudentAnswerDetailTlp::where('student_id', $student->id)->first();

                    $student->filled = !is_null($studentAnswerDetailTlp);
                    $student->studentAnswerDetailTlp = $studentAnswerDetailTlp;

                    return $student;
                });

                $students = $students->filter(function ($student) {
                    return $student->filled;
                });

                $students = $students->map(function ($student) {
                    $studentAnswerTlp = StudentAnswerTlp::where('student_answer_detail_tlp_id', $student->studentAnswerDetailTlp->id)->get();

                    $student->studentAnswerTlp = $studentAnswerTlp;
                    return $student;
                });

                return $this->successResponse(
                    StudentQuestionnaireFilledResource::collection($students),
                    'Student Questionnaires retrieved successfully'
                );
            } else if (request()->query('type') == 'AC') {
                $students = $students->map(function ($student) {
                    $studentAnswersAC = StudentAnswerAc::where('student_id', $student->id)->first();

                    $student->filled = !is_null($studentAnswersAC);
                    $student->studentAnswersAC = $studentAnswersAC;

                    return $student;
                });

                $students = $students->filter(function ($student) {
                    return $student->filled;
                });

                return $this->successResponse(
                    StudentAnswerACResource::collection($students),
                    'Student Questionnaires retrieved successfully'
                );
            } else {
                return $this->errorResponse('Invalid type', [], 400);
            }

            // return response()->json($studentQuestionnaires);
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
