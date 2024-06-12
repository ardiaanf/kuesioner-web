<?php

namespace App\Http\Controllers\API\Student;

use App\Models\StudentQuestionnaire;
use App\Http\Resources\Student\StudentQuestionnaireResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;

class StudentQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'student') {
            $studentQuestionnaires = StudentQuestionnaire::all();
            return $this->successResponse(StudentQuestionnaireResource::collection($studentQuestionnaires), 'Student Questionnaires retrieved successfully');
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
        if (Auth::user()->role == 'student') {
            $studentQuestionnaire = StudentQuestionnaire::with('studentElements.studentQuestions')->find($id);
            if (is_null($studentQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire retrieved successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
