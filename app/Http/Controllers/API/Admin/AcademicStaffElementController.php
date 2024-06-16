<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AcademicStaffElementResource;
use App\Models\AcadStaffElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $acadstaffElements = AcadStaffElement::all();
            return $this->successResponse(AcademicStaffElementResource::collection($acadstaffElements), 'Educational Personal Elements retrieved successfully.');
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
                'description' => 'nullable',
                'acad_staff_questionnaire_id' => 'required|exists:acad_staff_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $acadstaffElement = AcadStaffElement::create($input);

            return $this->successResponse(new AcademicStaffElementResource($acadstaffElement), 'Education Personel Element created successfully.', 201);
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
            $acadstaffElement = AcadStaffElement::with('acadstaffQuestions')->find($id);

            if (is_null($acadstaffElement)) {
                return $this->errorResponse('Education Personel Element not found.', [], 404);
            }

            return $this->successResponse(new AcademicStaffElementResource($acadstaffElement), 'Education Personel Element retrieved successfully.');
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
            $acadstaffElement = AcadStaffElement::with('acadstaffQuestions')->find($id);

            if (is_null($acadstaffElement)) {
                return $this->errorResponse('Education Personel Element not found.', [], 404);
            }

            return $this->successResponse(new AcademicStaffElementResource($acadstaffElement), 'Education Personel Element retrieved successfully.');
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
            $acadstaffElement = AcadStaffElement::find($id);

            if (is_null($acadstaffElement)) {
                return $this->errorResponse('Lecturer Element not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'lecturer_questionnaire_id' => 'required|exists:lecturer_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

             $acadstaffElement->name = $input['name'];
             $acadstaffElement->description = $input['description'];
             $acadstaffElement->save();

            return $this->successResponse(new AcademicStaffElementResource( $acadstaffElement), 'Education Personel Element updated successfully.');
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
                return $this->errorResponse('Education Personel Element not found.', [], 404);
            }

            $AcadStaffElement->delete();

            return $this->successResponse([], 'Education Personel Element deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
