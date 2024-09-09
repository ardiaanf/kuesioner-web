<?php

namespace App\Http\Controllers\API\Student;

use App\Models\Major;
use App\Http\Resources\student\MajorResource;
use App\Http\Controllers\API\BaseController;

class MajorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majors = Major::all();
        return $this->successResponse(MajorResource::collection($majors), 'Majors retrieved successfully.');
    }
}
