<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AcademicStaffElementResource;
use App\Http\Resources\Admin\AcadStaffElementResource;
use App\Models\AcadStaffElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AcademicStaffElementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $AcadStaffElements = AcadStaffElement::all();
            return $this->successResponse(AcadStaffElementResource::collection($AcadStaffElements), 'Education Personel Elements retrieved successfully.');
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
            // Log::info('Input data:', $input);
            // dd($input);
            // dd($input);

            // var_dump($input);
            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'acad_staff_questionnaire_id' => 'required|exists:acad_staff_questionnaires,id',
            ]);
            // var_dump($validator->errors());

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $AcadStaffElement = AcadStaffElement::create($input);

            return $this->successResponse(new AcadStaffElementResource($AcadStaffElement), 'Education Personel Element created successfully.', 201);
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
            $AcadStaffElement = AcadStaffElement::find($id);

            if (is_null($AcadStaffElement)) {
                return $this->errorResponse('Education Personel Element not found.', [], 404);
            }

            return $this->successResponse(new AcadStaffElementResource($AcadStaffElement), 'Education Personel Element retrieved successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }

    /**
     * Display the specified resource with relations.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithRelations($id)
    {
        if (Auth::user()->role == 'admin') {
            $AcadStaffElement = AcadStaffElement::with('acadstaffQuestions')->find($id);

            if (is_null($AcadStaffElement)) {
                return $this->errorResponse('Education Personal Element not found.', [], 404);
            }

            return $this->successResponse(new AcadStaffElementResource($AcadStaffElement), 'Education Personal Element retrieved successfully.');
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
            $AcadStaffElement = AcadStaffElement::find($id);

            if (is_null($AcadStaffElement)) {
                return $this->errorResponse('Education Personal Element not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'acad_staff_questionnaire_id' => 'required|exists:acad_staff_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $AcadStaffElement->name = $input['name'];
            $AcadStaffElement->description = $input['description'];
            $AcadStaffElement->save();

            return $this->successResponse(new AcadStaffElementResource($AcadStaffElement), 'Education Personal Element updated successfully.');
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
            $AcadStaffElement = AcadStaffElement::find($id);

            if (is_null($AcadStaffElement)) {
                return $this->errorResponse('Education Personal Element not found.', [], 404);
            }

            $AcadStaffElement->delete();

            return $this->successResponse([], 'Education Personal Element deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
