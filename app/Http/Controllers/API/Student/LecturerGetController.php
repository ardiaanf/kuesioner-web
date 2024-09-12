<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Lecturer; // Tambahkan import model Lecturer
use App\Models\LecturerCourse; // Tambahkan import model LecturerCourse
use App\Http\Resources\Student\LecturerGetResource; // Tambahkan import LecturerGetResource

class LecturerGetController extends BaseController
{
    public function index(Request $request) // Tambahkan parameter Request
    {
        $courseId = $request->query('course_id'); // Ambil course_id dari query string

        // Ambil dosen yang mengajar mata kuliah tertentu
        $lecturers = Lecturer::whereHas('lecturerCourses', function($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->get();

        return LecturerGetResource::collection($lecturers); // Kembalikan resource dalam bentuk koleksi
    }
}
