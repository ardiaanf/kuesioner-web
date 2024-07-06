<?php

namespace App\Http\Controllers\API\Student;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\StudentQuestionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Student\StudentQuestionnaireResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\StudentAnswerDetailTlp;
use App\Models\StudentAnswerTlp;
use App\Rules\AnswerWithinRange;

class StudentQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentQuestionnaires = StudentQuestionnaire::all();
        return $this->successResponse(StudentQuestionnaireResource::collection($studentQuestionnaires), 'Student Questionnaires retrieved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentQuestionnaire = StudentQuestionnaire::with('studentElements.studentQuestions')->find($id);
        if (is_null($studentQuestionnaire)) {
            return $this->errorResponse('Student Questionnaire not found', [], 404);
        }

        return $this->successResponse(new StudentQuestionnaireResource($studentQuestionnaire), 'Student Questionnaire retrieved successfully');
    }

    /**
     * Fill the questionnaire for TLP
     * One Element with multiple questions
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function fillQuestionTLP(Request $request)
    // {
    //     // Check if the student has filled the questionnaire
    //     $studentAnswerDetailTlp = StudentAnswerDetailTlp::where('student_id', Auth::user()->id)
    //         ->where('course_id', $request->course_id)
    //         ->where('student_class_id', $request->student_class_id)
    //         ->where('study_program_id', $request->study_program_id)
    //         ->where('major_id', $request->major_id)
    //         ->first();

    //     if ($studentAnswerDetailTlp) {
    //         return $this->errorResponse('You have filled the questionnaire', [], 400);
    //     }

    //     // Step 1: Validate the Request
    //     $validator = Validator::make($request->all(), [
    //         'major_id' => 'required|integer',
    //         'study_program_id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('study_programs', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('major_id', $request->major_id);
    //             }),
    //         ],
    //         'student_class_id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('student_classes', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('study_program_id', $request->study_program_id);
    //             }),

    //         ],
    //         'course_id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('courses', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('study_program_id', $request->study_program_id);
    //             }),

    //         ],
    //         'lecturer_id' => [
    //             'required',
    //             'integer',
    //             'exists:lecturers,id',
    //             Rule::exists('lecturer_courses', 'lecturer_id')->where(function ($query) use ($request) {
    //                 return $query->where('course_id', $request->course_id);
    //             }),
    //         ],
    //         'student_questionnaire.id' => 'required|integer',
    //         'student_questionnaire.student_element.id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('student_elements', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('student_questionnaire_id', $request->student_questionnaire['id']);
    //             }),

    //         ],
    //         'student_questionnaire.student_element.student_question.id.*' => [
    //             'required',
    //             'integer',
    //             Rule::exists('student_questions', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('student_element_id', $request->student_questionnaire['student_element']['id']);
    //             }),
    //         ],
    //         'student_questionnaire.student_element.student_question.answer.*' => [
    //             'required',
    //             'integer',
    //             new AnswerWithinRange($request->student_questionnaire['student_element']['student_question']['id'], $request->student_questionnaire['student_element']['student_question']['answer']),
    //         ],
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->errorResponse('Validation Error', $validator->errors(), 422);
    //     }

    //     try {
    //         // Step 2: Handle Transactions
    //         DB::beginTransaction();

    //         // Step 3: Insert into StudentAnswerDetailTlp with the corrected fields
    //         $studentAnswerDetailTlp = StudentAnswerDetailTlp::create([
    //             'major_id' => $request->major_id,
    //             'study_program_id' => $request->study_program_id,
    //             'student_class_id' => $request->student_class_id,
    //             'course_id' => $request->course_id,
    //             'lecturer_id' => $request->lecturer_id,
    //             'student_id' => Auth::user()->id,
    //         ]);

    //         // Step 4: Insert into StudentAnswerTlp with the corrected fields
    //         foreach ($request->student_questionnaire['student_element']['student_question']['id'] as $index => $questionId) {
    //             $answer = $request->student_questionnaire['student_element']['student_question']['answer'][$index];
    //             StudentAnswerTlp::create([
    //                 'answer' => $answer,
    //                 'student_answer_detail_tlp_id' => $studentAnswerDetailTlp->id,
    //                 'student_questionnaire_id' => $request->student_questionnaire['id'],
    //                 'student_element_id' => $request->student_questionnaire['student_element']['id'],
    //                 'student_question_id' => $questionId,
    //             ]);
    //         }

    //         DB::commit();
    //         return $this->successResponse([], 'Questionnaire filled successfully', 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
    //     }
    // }

    /**
     * Fill the questionnaire for TLP
     * Multiple Elements with multiple questions
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fillQuestionTLP(Request $request)
    {
        $studentAnswerDetailTlp = StudentAnswerDetailTlp::where('student_id', Auth::user()->id)
            ->where('course_id', $request->course_id)
            ->where('student_class_id', $request->student_class_id)
            ->where('study_program_id', $request->study_program_id)
            ->where('major_id', $request->major_id)
            ->first();

        if ($studentAnswerDetailTlp) {
            return $this->errorResponse('You have filled the questionnaire', [], 400);
        }

        $validator = Validator::make($request->all(), [
            'major_id' => 'required|integer',
            'study_program_id' => [
                'required',
                'integer',
                Rule::exists('study_programs', 'id')->where(function ($query) use ($request) {
                    return $query->where('major_id', $request->major_id);
                }),
            ],
            'student_class_id' => [
                'required',
                'integer',
                Rule::exists('student_classes', 'id')->where(function ($query) use ($request) {
                    return $query->where('study_program_id', $request->study_program_id);
                }),
            ],
            'course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id')->where(function ($query) use ($request) {
                    return $query->where('study_program_id', $request->study_program_id);
                }),

            ],
            'lecturer_id' => [
                'required',
                'integer',
                'exists:lecturers,id',
                Rule::exists('lecturer_courses', 'lecturer_id')->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id);
                }),
            ],
            'student_questionnaire.id' => 'required|integer',
            'student_questionnaire.student_elements.*.id' => [
                'required',
                'integer',
                Rule::exists('student_elements', 'id')->where(function ($query) use ($request) {
                    return $query->where('student_questionnaire_id', $request->student_questionnaire['id']);
                }),
            ],
            'student_questionnaire.student_elements.*.student_question.id.*' => 'required|integer',
            'student_questionnaire.student_elements.*.student_question.answer.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $studentAnswerDetailTlp = StudentAnswerDetailTlp::create([
                'major_id' => $request->major_id,
                'study_program_id' => $request->study_program_id,
                'student_class_id' => $request->student_class_id,
                'course_id' => $request->course_id,
                'lecturer_id' => $request->lecturer_id,
                'student_id' => Auth::user()->id,
            ]);

            foreach ($request->student_questionnaire['student_elements'] as $element) {
                foreach ($element['student_question']['id'] as $index => $questionId) {
                    $answer = $element['student_question']['answer'][$index];
                    StudentAnswerTlp::create([
                        'answer' => $answer,
                        'student_answer_detail_tlp_id' => $studentAnswerDetailTlp->id,
                        'student_questionnaire_id' => $request->student_questionnaire['id'],
                        'student_element_id' => $element['id'],
                        'student_question_id' => $questionId,
                    ]);
                }
            }

            DB::commit();
            return $this->successResponse([], 'Questionnaire filled successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
        }
    }

    // TODO: Error Handling for too much question / answer has not match with count of question
    // TODO: Create Method to Get the Answered Questionnaire
    // TODO: Create Method to Get the Answered Questionnaire by Student ID
    // TODO: Create Method to Fill the Questionnaire for AC
}
