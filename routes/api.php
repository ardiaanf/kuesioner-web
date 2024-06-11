<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{
    AdminAuthController,
    LecturerAuthController,
    AcadStaffAuthController,
    StudentAuthController,
};

Route::post('auth/admin', [AdminAuthController::class, 'signin']);
Route::post('auth/lecturer', [LecturerAuthController::class, 'signin']);
Route::post('auth/acadstaff', [AcadStaffAuthController::class, 'signin']);
Route::post('auth/student', [StudentAuthController::class, 'signin']);
