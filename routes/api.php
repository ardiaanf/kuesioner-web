<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
    Auth\AdminAuthController,
    Auth\LecturerAuthController,
    Auth\AcadStaffAuthController,
    Auth\StudentAuthController,
    Admin\StudentQuestionnaireController as AdminStudentQuestionnaireController,
    Admin\StudentElementController as AdminStudentElementController,
    Admin\StudentQuestionController as AdminStudentQuestionController,
    Admin\LecturerQuestionnaireController as AdminLecturerQuestionnaireController,
    Admin\LecturerQuestionController as AdminLecturerQuestionController,
    Admin\LecturerElementController as AdminLecturerElementController,
    Admin\AcademicStaffQuestionnaireController as AdminAcademicStaffQuestionnaireController,
    Admin\AcademicStaffElementController as AdminAcademicStaffElementController,
    Admin\AcademicStaffQuestionController as AdminAcademicStaffQuestionController,
    Admin\AdminController,
    Admin\LectureController,
    Admin\AcadStaffController,
    Student\StudentQuestionnaireController,
};


Route::post('auth/admin', [AdminAuthController::class, 'signin']);
Route::post('auth/lecturer', [LecturerAuthController::class, 'signin']);
Route::post('auth/acadstaff', [AcadStaffAuthController::class, 'signin']);
Route::post('auth/student', [StudentAuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    /**
     * ROUTES FOR ADMIN
     */
    // Student Questionnaires
    Route::get('admin/student-questionnaires', [AdminStudentQuestionnaireController::class, 'index']);
    Route::post('admin/student-questionnaires', [AdminStudentQuestionnaireController::class, 'store']);
    Route::get('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'show']);
    Route::get('admin/student-questionnaires/{studentQuestionnaire}/relations', [AdminStudentQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'update']);
    Route::delete('admin/student-questionnaires/{studentQuestionnaire}', [AdminStudentQuestionnaireController::class, 'destroy']);

    // Student Elements
    Route::get('admin/student-elements', [AdminStudentElementController::class, 'index']);
    Route::post('admin/student-elements', [AdminStudentElementController::class, 'store']);
    Route::get('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'show']);
    Route::get('admin/student-elements/{studentElement}/relations', [AdminStudentElementController::class, 'showWithRelations']);
    Route::put('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'update']);
    Route::delete('admin/student-elements/{studentElement}', [AdminStudentElementController::class, 'destroy']);

    // Student Questions
    Route::get('admin/student-questions', [AdminStudentQuestionController::class, 'index']);
    Route::post('admin/student-questions', [AdminStudentQuestionController::class, 'store']);
    Route::get('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'show']);
    Route::put('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'update']);
    Route::delete('admin/student-questions/{studentQuestion}', [AdminStudentQuestionController::class, 'destroy']);

    // Lecturer Questionnaire
    Route::get('admin/lecturer-questionnaires', [AdminLecturerQuestionnaireController::class, 'index']);
    Route::post('admin/lecturer-questionnaires', [AdminLecturerQuestionnaireController::class, 'store']);
    Route::get('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'show']);
    Route::get('admin/lecturer-questionnaires/{lecturerQuestionnaire}/relations', [AdminLecturerQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'update']);
    Route::delete('admin/lecturer-questionnaires/{lecturerQuestionnaire}', [AdminLecturerQuestionnaireController::class, 'destroy']);

    // Lecturer Elements
    Route::get('admin/lecturer-elements', [AdminLecturerElementController::class, 'index']);
    Route::post('admin/lecturer-elements', [AdminLecturerElementController::class, 'store']);
    Route::get('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'show']);
    Route::get('admin/lecturer-elements/{lecturerElement}/relations', [AdminLecturerElementController::class, 'showWithRelations']);
    Route::put('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'update']);
    Route::delete('admin/lecturer-elements/{lecturerElement}', [AdminLecturerElementController::class, 'destroy']);

    // Lecturer Question
    Route::get('admin/lecturer-questions', [AdminLecturerQuestionController::class, 'index']);
    Route::post('admin/lecturer-questions', [AdminLecturerQuestionController::class, 'store']);
    Route::get('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'show']);
    Route::put('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'update']);
    Route::delete('admin/lecturer-questions/{lecturerQuestion}', [AdminLecturerQuestionController::class, 'destroy']);

    // Academic staff Questionnaire
    Route::get('admin/acadstaff-questionnaires', [AdminAcademicStaffQuestionnaireController::class, 'index']);
    Route::post('admin/acadstaff-questionnaires', [AdminAcademicStaffQuestionnaireController::class, 'store']);
    Route::get('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcademicStaffQuestionnaireController::class, 'show']);
    Route::get('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}/relations', [AdminAcademicStaffQuestionnaireController::class, 'showWithRelations']);
    Route::put('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcademicStaffQuestionnaireController::class, 'update']);
    Route::delete('admin/acadstaff-questionnaires/{acadstaffQuestionnaire}', [AdminAcademicStaffQuestionnaireController::class, 'destroy']);

    // Academic staff Elements
    Route::get('admin/acadstaff-elements', [AdminAcademicStaffElementController::class, 'index']);
    Route::post('admin/acadstaff-elements', [AdminAcademicStaffElementController::class, 'store']);
    Route::get('admin/acadstaff-elements/{acadstaffElement}', [AdminAcademicStaffElementController::class, 'show']);
    Route::get('admin/acadstaff-elements/{acadstaffElement}/relations', [AdminAcademicStaffElementController::class, 'showWithRelations']);
    Route::put('admin/acadstaff-elements/{acadstaffElement}', [AdminAcademicStaffElementController::class, 'update']);
    Route::delete('admin/acadstaff-elements/{acadstaffElement}', [AdminAcademicStaffElementController::class, 'destroy']);

    // Academic staff Question
    Route::get('admin/acadstaff-questions', [AdminAcademicStaffQuestionController::class, 'index']);
    Route::post('admin/acadstaff-questions', [AdminAcademicStaffQuestionController::class, 'store']);
    Route::get('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcademicStaffQuestionController::class, 'show']);
    Route::put('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcademicStaffQuestionController::class, 'update']);
    Route::delete('admin/acadstaff-questions/{acadstaffQuestion}', [AdminAcademicStaffQuestionController::class, 'destroy']);

    // Account Management Admin
    Route::get('admin/admins', [AdminController::class, 'index']);
    Route::post('admin/admins', [AdminController::class, 'store']);
    Route::get('admin/admins/{admin}', [AdminController::class, 'show']);
    Route::put('admin/admins/{admin}', [AdminController::class, 'update']);
    Route::delete('admin/admins/{admin}', [AdminController::class, 'destroy']);

    // Account Management Lecturer
    Route::get('admin/lecturer', [LectureController::class, 'index']);
    Route::post('admin/lecturer', [LectureController::class, 'store']);
    Route::get('admin/lecturer/{admin}', [LectureController::class, 'show']);
    Route::put('admin/lecturer/{admin}', [LectureController::class, 'update']);
    Route::delete('admin/lecturer/{admin}', [LectureController::class, 'destroy']);

    // Account Management Lecturer
    Route::get('admin/acadstaff', [AcadStaffController::class, 'index']);
    Route::post('admin/acadstaff', [AcadStaffController::class, 'store']);
    Route::get('admin/acadstaff/{admin}', [AcadStaffController::class, 'show']);
    Route::put('admin/acadstaff/{admin}', [AcadStaffController::class, 'update']);
    Route::delete('admin/acadstaff/{admin}', [AcadStaffController::class, 'destroy']);

    /**
     * ROUTES FOR STUDENT
     */
    // Student Questionnaires
    Route::get('student/student-questionnaires', [StudentQuestionnaireController::class, 'index']);
    Route::get('student/student-questionnaires/{studentQuestionnaire}', [StudentQuestionnaireController::class, 'show']);
});
