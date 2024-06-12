<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
    Auth\AdminAuthController,
    Auth\LecturerAuthController,
    Auth\AcadStaffAuthController,
    Auth\StudentAuthController,
    Admin\StudentQuestionnaireController as AdminStudentQuestionnaireController,
    Admin\StudentElementController as AdminStudentElementController,
    Admin\StudentQuestionController as AdminStudentQuestionController
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
});
