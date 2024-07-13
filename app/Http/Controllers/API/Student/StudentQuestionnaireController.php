<?php

namespace App\Http\Controllers\API\Student;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\StudentAnswerTlp;
use App\Rules\AnswerWithinRange;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidStudentQuestion;
use App\Models\StudentQuestionnaire;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAnswerDetailTlp;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Student\StudentQuestionnaireResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Student\StudentQuestionnaireFilledResource;
use App\Models\StudentAnswerAc;

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
            'student_questionnaire.id' => 'required|integer|exists:student_questionnaires,id',
            'student_questionnaire.student_elements.*.id' => [
                'required',
                'integer',
                Rule::exists('student_elements', 'id')->where(function ($query) use ($request) {
                    return $query->where('student_questionnaire_id', $request->student_questionnaire['id']);
                }),
            ],
            'student_questionnaire.student_elements.*.student_question.id.*' => [
                'required',
                'integer',
                new ValidStudentQuestion($request),
            ],
            'student_questionnaire.student_elements.*.student_question.answer.*' => [
                'required',
                'integer',
                new AnswerWithinRange($request),
            ]
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

            $studentAnswerDetailTlp = StudentAnswerDetailTlp::with('studentAnswerTlp')->find($studentAnswerDetailTlp->id);
            return $this->successResponse(new StudentQuestionnaireFilledResource($studentAnswerDetailTlp), 'Questionnaire filled successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function showFilledQuestionTLP($id)
    {
        $studentAnswerDetailTlp = StudentAnswerDetailTlp::where('student_id', Auth::user()->id)
            ->where('id', $id)
            ->with('studentAnswerTlp')
            ->first();

        if (is_null($studentAnswerDetailTlp)) {
            return $this->errorResponse('Student Answer Detail TLP not found', [], 404);
        }

        return $this->successResponse(new StudentQuestionnaireFilledResource($studentAnswerDetailTlp), 'Student Answer Detail TLP retrieved successfully');
    }

    // public function fillQuestionAC(Request $request)
    // {
    //     $studentAnswerAC = StudentAnswerAc::where('student_id', Auth::user()->id)
    //         ->where('student_questionnaire_id', $request->student_questionnaire_id)
    //         ->where('student_element_id', $request->student_element_id)
    //         ->where('student_question_id', $request->student_question_id)
    //         ->first();

    //     if ($studentAnswerAC) {
    //         return $this->errorResponse('You have filled the questionnaire', [], 400);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'student_questionnaire.id' => 'required|integer|exists:student_questionnaires,id',
    //         'student_questionnaire.student_elements.*.id' => [
    //             'required',
    //             'integer',
    //             Rule::exists('student_elements', 'id')->where(function ($query) use ($request) {
    //                 return $query->where('student_questionnaire_id', $request->student_questionnaire['id']);
    //             }),
    //         ],
    //         'student_questionnaire.student_elements.*.student_question.id.*' => [
    //             'required',
    //             'integer',
    //             new ValidStudentQuestion($request),
    //         ],
    //         'student_questionnaire.student_elements.*.student_question.answer.*' => [
    //             'required',
    //             'integer',
    //             new AnswerWithinRange($request),
    //         ]
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->errorResponse('Validation Error', $validator->errors(), 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         foreach ($request->student_questionnaire['student_elements'] as $element) {
    //             foreach ($element['student_question']['id'] as $index => $questionId) {
    //                 $answer = $element['student_question']['answer'][$index];
    //                 StudentAnswerTlp::create([
    //                     'answer' => $answer,
    //                     'student_id' => Auth::user()->id,
    //                     'student_questionnaire_id' => $request->student_questionnaire['id'],
    //                     'student_element_id' => $element['id'],
    //                     'student_question_id' => $questionId,
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         // $studentAnswerDetailTlp = StudentAnswerDetailTlp::with('studentAnswerTlp')->find($studentAnswerDetailTlp->id);
    //         return $this->successResponse([], 'Questionnaire filled successfully', 201);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
    //     }
    // }

    // TODO: Create Method to Get the Answered Questionnaire AC by Student ID
    // TODO: Ranking for lecturer based on the questionnaire
}
