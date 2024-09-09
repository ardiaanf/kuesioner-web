<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\StudyProgram;
use App\Http\Resources\Admin\StudyProgramResource;
use App\Http\Controllers\API\BaseController as BaseController;

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
