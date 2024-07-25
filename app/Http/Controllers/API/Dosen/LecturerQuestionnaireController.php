<?php

namespace App\Http\Controllers\API\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dosen\LecturerElementResource;
use App\Http\Resources\Dosen\LecturerQuestionnaireResource;
use App\Models\LecturerAnswer;
use App\Models\LecturerQuestionnaire;
use App\Rules\LecturerAnswerWithinRange;
use App\Rules\ValidLecturerQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LecturerQuestionnaireController extends Controller
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
        $lecturerQuestionnaire = LecturerQuestionnaire::with('lecturerElements.lecturerQuestions')->find($id);
        if (is_null($lecturerQuestionnaire)) {
            return $this->errorResponse('Lecturer Questionnaire not found', [], 404);
        }

        return $this->successResponse(new LecturerElementResource($lecturerQuestionnaire), 'Lecturer Questionnaire retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function fillQuestionAC(Request $request)
     {
         $lecturerAnswerAC = LecturerAnswer::where('lecturer_id', Auth::user()->id)
             ->where('lecturer_questionnaire_id', $request->lecturer_questionnaire['id'])
             ->first();

         if ($lecturerAnswerAC) {
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
             'student_questionnaire.student_elements.*.student_question.answer.*' => [
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

             foreach ($request->student_questionnaire['student_elements'] as $element) {
                 foreach ($element['student_question']['id'] as $index => $questionId) {
                     $answer = $element['student_question']['answer'][$index];
                     StudentAnswerAC::create([
                         'answer' => $answer,
                         'student_id' => Auth::user()->id,
                         'student_questionnaire_id' => $request->student_questionnaire['id'],
                         'student_element_id' => $element['id'],
                         'student_question_id' => $questionId,
                     ]);
                 }
             }

             DB::commit();

             $studentAnswers = StudentAnswerAc::where('student_id', Auth::user()->id)
                 ->where('student_questionnaire_id', $request->student_questionnaire['id'])
                 ->with('studentQuestionnaire', 'studentElement', 'studentQuestion', 'student')
                 ->get();

             if ($studentAnswers->isEmpty()) {
                 return response()->json([]);
             }

             $groupedAnswers = [
                 'student_questionnaire' => $studentAnswers->first()->studentQuestionnaire->name,
                 'student_name' => $studentAnswers->first()->student->name,
                 'answers' => $studentAnswers->map(function ($item) {
                     return [
                         'student_element' => $item->studentElement->name,
                         'student_question' => $item->studentQuestion->question,
                         'answer' => $item->answer
                     ];
                 })->toArray(),
                 'created_at' => $studentAnswers->first()->created_at,
             ];

             return $this->successResponse(new StudentAnswerACResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
         } catch (\Exception $e) {
             DB::rollBack();
             return $this->errorResponse('Internal Server Error', $e->getMessage(), 500);
         }
     }

     public function showFilledQuestionAC($id)
     {
         $studentAnswers = StudentAnswerAc::where('student_id', Auth::user()->id)
             ->where('student_questionnaire_id', $id)
             ->with('studentQuestionnaire', 'studentElement', 'studentQuestion', 'student')
             ->get();

         if ($studentAnswers->isEmpty()) {
             return $this->errorResponse('Student Answer AC not found', [], 404);
         }

         $groupedAnswers = [
             'student_questionnaire' => $studentAnswers->first()->studentQuestionnaire->name,
             'student_name' => $studentAnswers->first()->student->name,
             'answers' => $studentAnswers->map(function ($item) {
                 return [
                     'student_element' => $item->studentElement->name,
                     'student_question' => $item->studentQuestion->question,
                     'answer' => $item->answer
                 ];
             })->toArray(),
             'created_at' => $studentAnswers->first()->created_at,
         ];

         return $this->successResponse(new StudentAnswerACResource((object) $groupedAnswers), 'Questionnaire filled successfully', 201);
     }
}
