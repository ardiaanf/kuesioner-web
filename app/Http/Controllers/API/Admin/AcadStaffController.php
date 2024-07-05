<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Admin\AcadStaffResource;
use App\Models\AcadStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcadStaffController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acadstaff = AcadStaff::all();
        return $this->successResponse(AcadStaffResource::collection($acadstaff), 'Education Personal retrieved successfully.');
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
            'reg_number' => 'required|unique:acad_staffs,reg_number',
            'email' => 'required|email|unique:acad_staffs,email',
            'password' => 'required',
            'acad_staff_work_unit_id' => 'required|exists:acad_staff_work_units,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $lecturer = AcadStaff::create([
            'name' => $input['name'],
            'reg_number' => $input['reg_number'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'acad_staff_work_unit_id' => $input['acad_staff_work_unit_id']
        ]);

        return $this->successResponse(new AcadStaffResource($lecturer), 'Education Personel created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acadstaff = AcadStaff::find($id);

        if (is_null($acadstaff)) {
            return $this->errorResponse('Education Personel not found.', [], 404);
        }

        return $this->successResponse(new AcadStaffResource($acadstaff), 'Education Personel retrieved successfully.');
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
        $acadstaff = AcadStaff::find($id);

        if (is_null($acadstaff)) {
            return $this->errorResponse('Education Personel not found.', [], 404);
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'reg_number' => 'required|unique:acad_staffs,reg_number,' . $id,
            'email' => 'required|email|unique:acad_staffs,email,' . $id,
            'password' => 'required',
            'acad_staff_work_unit_id' => 'required|exists:acad_staff_work_units,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $acadstaff->name = $input['name'];
        $acadstaff->reg_number = $input['reg_number'];
        $acadstaff->email = $input['email'];
        $acadstaff->password = bcrypt($input['password']);
        $acadstaff->acad_staff_work_unit_id = $input['acad_staff_work_unit_id'];
        $acadstaff->save();

        return $this->successResponse(new AcadStaffResource($acadstaff), 'Education Personel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acadstaff = AcadStaff::find($id);

        if (is_null($acadstaff)) {
            return $this->errorResponse('Education Personel not found.', [], 404);
        }

        $acadstaff->delete();

        return $this->successResponse([], 'Education Personel deleted successfully.');
    }
}
