<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\StudyProgram;
use App\Http\Resources\Admin\StudyProgramResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyProgramController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = StudyProgram::all();
        return $this->successResponse(StudyProgramResource::collection($admins), 'Admins retrieved successfully.');
    }
}
