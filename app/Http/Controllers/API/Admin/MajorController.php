<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Major;
// use App\Http\Resources\admin\MajorResource;
use App\Http\Controllers\API\BaseController;

class MajorController extends BaseController
{
    public function index()
    {
        $majors = Major::all();
        return response()->json([
            'message' => 'Majors retrieved successfully.',
            'data' => $majors,
        ], 200);
        // return $this->successResponse(MajorResource::collection($majors), 'Majors retrieved successfully.');
    }
}
