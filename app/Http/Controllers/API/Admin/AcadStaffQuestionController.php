<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AcadStaffQuestionResource;
use App\Models\AcadStaffElement;
use App\Models\AcadStaffQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AcadStaffQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $AcadStaffQuestions = AcadStaffQuestion::all();
            return $this->successResponse(AcadStaffQuestionResource::collection($AcadStaffQuestions), 'Education Personel Questions retrieved successfully.');
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
                'question' => 'required',
                'min_range' => 'required',
                'max_range' => 'required',
                'label' => 'required|array',
                'acad_staff_element_id' => 'required|exists:acad_staff_elements,id',
            ]);


            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $LecturerQuestion = AcadStaffQuestion::create($input);

            return $this->successResponse(new AcadStaffQuestionResource($LecturerQuestion), 'Education Personel Question created successfully.', 201);
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
            $AcadStaffQuestion = AcadStaffQuestion::find($id);

            if (is_null($AcadStaffQuestion)) {
                return $this->errorResponse('Education Personel Question not found.', [], 404);
            }

            return $this->successResponse(new AcadStaffQuestionResource($AcadStaffQuestion), 'Education personel Question retrieved successfully.');
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
    // public function showWithRelations($id)
    // {
    //     if (Auth::user()->role == 'admin') {
    //         $AcadStaffQuestion = AcadStaffElement::with('acadstaffQuestions')->find($id);

    //         if (is_null($AcadStaffQuestion)) {
    //             return $this->errorResponse('Education Personel Element not found.', [], 404);
    //         }

    //         return $this->successResponse(new AcadStaffQuestionResource($AcadStaffQuestion), 'Education Personel Element retrieved successfully.');
    //     } else {
    //         return $this->errorResponse('Unauthorized', [], 401);
    //     }
    // }


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
            $AcadStaffQuestion = AcadStaffQuestion::find($id);

            if (is_null($AcadStaffQuestion)) {
                return $this->errorResponse('Education Personel Question not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'question' => 'required',
                'min_range' => 'required',
                'max_range' => 'required',
                'label' => 'required|array',
                'acad_staff_element_id' => 'required|exists:acad_staff_elements,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $AcadStaffQuestion->question = $input['question'];
            $AcadStaffQuestion->min_range = $input['min_range'];
            $AcadStaffQuestion->max_range = $input['max_range'];
            $AcadStaffQuestion->label = $input['label'];
            $AcadStaffQuestion->acad_staff_element_id = $input['acad_staff_element_id'];
            $AcadStaffQuestion->save();

            return $this->successResponse(new AcadStaffQuestionResource($AcadStaffQuestion), 'Education Personel Question updated successfully.');
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
            $AcadStaffQuestion = AcadStaffQuestion::find($id);

            if (is_null($AcadStaffQuestion)) {
                return $this->errorResponse('Education Personel Question not found.', [], 404);
            }

            $AcadStaffQuestion->delete();

            return $this->successResponse([], 'Education Personel deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
