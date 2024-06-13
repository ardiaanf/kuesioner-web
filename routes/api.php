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
    Admin\AdminController,
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

    // Account Management
    Route::get('admin/admins', [AdminController::class, 'index']);
    Route::post('admin/admins', [AdminController::class, 'store']);
    Route::get('admin/admins/{admin}', [AdminController::class, 'show']);
    Route::put('admin/admins/{admin}', [AdminController::class, 'update']);
    Route::delete('admin/admins/{admin}', [AdminController::class, 'destroy']);


    /**
     * ROUTES FOR STUDENT
     */
    // Student Questionnaires
    Route::get('student/student-questionnaires', [StudentQuestionnaireController::class, 'index']);
    Route::get('student/student-questionnaires/{studentQuestionnaire}', [StudentQuestionnaireController::class, 'show']);
});
