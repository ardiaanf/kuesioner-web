<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
    Auth\AdminAuthController,
    Auth\LecturerAuthController,
    Auth\AcadStaffAuthController,
    Auth\StudentAuthController,
    Admin\StudentQuestionnaireController
};

Route::post('auth/admin', [AdminAuthController::class, 'signin']);
Route::post('auth/lecturer', [LecturerAuthController::class, 'signin']);
Route::post('auth/acadstaff', [AcadStaffAuthController::class, 'signin']);
Route::post('auth/student', [StudentAuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('student-questionnaires', StudentQuestionnaireController::class);
});
