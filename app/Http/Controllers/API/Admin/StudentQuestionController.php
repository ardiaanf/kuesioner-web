<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\StudentQuestion;
use App\Http\Resources\Admin\StudentQuestionResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $StudentQuestions = StudentQuestion::all();
            return $this->successResponse(StudentQuestionResource::collection($StudentQuestions), 'Student Questions retrieved successfully.');
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
                'student_element_id' => 'required|exists:student_elements,id',
            ]);


            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $StudentQuestion = StudentQuestion::create($input);

            return $this->successResponse(new StudentQuestionResource($StudentQuestion), 'Student Question created successfully.', 201);
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
            $StudentQuestion = StudentQuestion::find($id);

            if (is_null($StudentQuestion)) {
                return $this->errorResponse('Student Question not found.', [], 404);
            }

            return $this->successResponse(new StudentQuestionResource($StudentQuestion), 'Student Question retrieved successfully.');
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
            $StudentQuestion = StudentQuestion::find($id);

            if (is_null($StudentQuestion)) {
                return $this->errorResponse('Student Question not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'question' => 'required',
                'min_range' => 'required',
                'max_range' => 'required',
                'label' => 'required|array',
                'student_element_id' => 'required|exists:student_elements,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $StudentQuestion->question = $input['question'];
            $StudentQuestion->min_range = $input['min_range'];
            $StudentQuestion->max_range = $input['max_range'];
            $StudentQuestion->label = $input['label'];
            $StudentQuestion->student_element_id = $input['student_element_id'];
            $StudentQuestion->save();

            return $this->successResponse(new StudentQuestionResource($StudentQuestion), 'Student Question updated successfully.');
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
            $StudentQuestion = StudentQuestion::find($id);

            if (is_null($StudentQuestion)) {
                return $this->errorResponse('Student Question not found.', [], 404);
            }

            $StudentQuestion->delete();

            return $this->successResponse([], 'Student Question deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
