<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\StudentClassResource;
use App\Models\StudentClass;

class StudentClassController extends BaseController
{
    public function index()
    {
        // Mengambil kelas dengan relasi 'students' dan 'studyProgram'
        $classes = StudentClass::all();
        return $this->successResponse(StudentClassResource::collection($classes), 'Student Classes retrieved successfully.');
    }
}
