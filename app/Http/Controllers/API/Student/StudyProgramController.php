<?php

namespace App\Http\Controllers\API\Student;

use App\Models\StudyProgram;
use App\Http\Resources\Student\StudyProgramResource;
use App\Http\Controllers\API\BaseController;

class StudyProgramController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyPrograms = StudyProgram::all();
        return $this->successResponse(StudyProgramResource::collection($studyPrograms), 'Study Programs retrieved successfully.');
    }
}
