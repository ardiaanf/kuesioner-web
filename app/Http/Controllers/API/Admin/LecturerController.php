<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Admin\LecturerResource;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LecturerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lecturer = Lecturer::all();
        return $this->successResponse(LecturerResource::collection($lecturer), 'Lecturer retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'reg_number' => 'required|unique:lecturers,reg_number',
            'email' => 'required|email|unique:lecturers,email',
            'password' => 'required',
            'work_period' => 'required',
            'lecturer_employment_status_id' => 'required|exists:lecturer_employment_statuses,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $lecturer = Lecturer::create([
            'name' => $input['name'],
            'reg_number' => $input['reg_number'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'work_period' => $input['work_period'],
            'lecturer_employment_status_id' => $input['lecturer_employment_status_id']
        ]);

        return $this->successResponse(new LecturerResource($lecturer), 'Lecturer created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lecturer = Lecturer::find($id);

        if (is_null($lecturer)) {
            return $this->errorResponse('lecturer not found.', [], 404);
        }

        return $this->successResponse(new LecturerResource($lecturer), 'Lecturer retrieved successfully.');
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
        $lecturer = Lecturer::find($id);

        if (is_null($lecturer)) {
            return $this->errorResponse('Lecturer not found.', [], 404);
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'reg_number' => 'required|unique:lecturers,reg_number,' . $id,
            'email' => 'required|email|unique:lecturers,email,' . $id,
            'password' => 'required',
            'work_period' => 'required',
            'lecturer_employment_status_id' => 'required|exists:lecturer_employment_statuses,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $lecturer->name = $input['name'];
        $lecturer->reg_number = $input['reg_number'];
        $lecturer->email = $input['email'];
        $lecturer->password = bcrypt($input['password']);
        $lecturer->work_period = $input['work_period'];
        $lecturer->lecturer_employment_status_id = $input['lecturer_employment_status_id'];
        $lecturer->save();

        return $this->successResponse(new LecturerResource($lecturer), 'Lecturer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecturer = Lecturer::find($id);

        if (is_null($lecturer)) {
            return $this->errorResponse('Lecturer not found.', [], 404);
        }

        $lecturer->delete();

        return $this->successResponse([], 'Lecturer deleted successfully.');
    }
}
