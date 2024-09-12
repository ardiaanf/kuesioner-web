<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Student\ClassResource;
use App\Models\StudentClass;

class ClassController extends BaseController
{
    public function index()
    {
        // Mengambil kelas dengan relasi 'students' dan 'studyProgram'
        $classes = StudentClass::with(['students', 'studyProgram'])->get();
        return ClassResource::collection($classes, 'Class retrieved successfully.');
    }

    // public function show($id)
    // {
    //     $class = StudentClass::with(['students', 'studyProgram'])->findOrFail($id);
    //     return new ClassResource($class);
    // }
}
