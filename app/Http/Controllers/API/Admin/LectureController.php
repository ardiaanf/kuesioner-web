<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LectureResource;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LectureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $lecturer = Lecturer::all();
            return $this->successResponse(LectureResource::collection($lecturer), 'Lecturer retrieved successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'reg_number' => 'required',
                'email' => 'required|email|unique:lecturers,email',
                'password' => 'required',
                'work_period' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $lecturer = Lecturer::create([
                'name' => $input['name'],
                'reg_number' => $input['reg_number'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'work_period' => $input['work_period']
            ]);

            return $this->successResponse(new LectureResource($lecturer), 'Lecture created successfully.', 201);
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->role == 'admin') {
            $lecturer = Lecturer::find($id);

            if (is_null($lecturer)) {
                return $this->errorResponse('Admin lecture not found.', [], 404);
            }

            return $this->successResponse(new LectureResource($lecturer), 'Lecture retrieved successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'admin') {
            $lecturer = Lecturer::find($id);

            if (is_null($lecturer)) {
                return $this->errorResponse('Admin not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'reg_number' => 'required',
                'email' => 'required|email|unique:admins,email,' . $id,
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $lecturer->name = $input['name'];
            $lecturer->reg_number = $input['reg_number'];
            $lecturer->email = $input['email'];
            $lecturer->password = bcrypt($input['password']);
            $lecturer->save();

            return $this->successResponse(new LectureResource($lecturer), 'Lecture updated successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $lecturer = Lecturer::find($id);

            if (is_null($lecturer)) {
                return $this->errorResponse('Lecturer Admin not found.', [], 404);
            }

            $lecturer->delete();

            return $this->successResponse([], 'Lecturer deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
