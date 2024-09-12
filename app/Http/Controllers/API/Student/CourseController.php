<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Course; // Tambahkan import model Course
use App\Http\Resources\Student\CourseResource; // Tambahkan import CourseResource

class CourseController extends BaseController
{
    public function index() // Tambahkan method index
    {
        $courses = Course::all(); // Ambil semua data course
        return CourseResource::collection($courses); // Kembalikan resource dalam bentuk koleksi
    }
}
