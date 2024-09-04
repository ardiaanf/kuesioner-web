<?php

use App\Http\Controllers\Web\Auth\LoginAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/admin', function () {
    return view('auth.admin');
});

Route::get('/auth/lecturer', function () {
    return view('auth.lecturer');
});

Route::get('/auth/student', function () {
    return view('auth.student');
});

Route::get('/auth/acad-staff', function () {
    return view('auth.acadstaff');
});


