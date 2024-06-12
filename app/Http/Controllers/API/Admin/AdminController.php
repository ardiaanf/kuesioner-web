<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $admins = Admin::all();
            return $this->successResponse(AdminResource::collection($admins), 'Admins retrieved successfully.');
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
                'email' => 'required|email|unique:admins,email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $admin = Admin::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);

            return $this->successResponse(new AdminResource($admin), 'Admin created successfully.', 201);
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
            $admin = Admin::find($id);

            if (is_null($admin)) {
                return $this->errorResponse('Admin not found.', [], 404);
            }

            return $this->successResponse(new AdminResource($admin), 'Admin retrieved successfully.');
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
            $admin = Admin::find($id);

            if (is_null($admin)) {
                return $this->errorResponse('Admin not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . $id,
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $admin->name = $input['name'];
            $admin->email = $input['email'];
            $admin->password = bcrypt($input['password']);
            $admin->save();

            return $this->successResponse(new AdminResource($admin), 'Admin updated successfully.');
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
            $admin = Admin::find($id);

            if (is_null($admin)) {
                return $this->errorResponse('Admin not found.', [], 404);
            }

            $admin->delete();

            return $this->successResponse([], 'Admin deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
