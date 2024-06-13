<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LecturerQuestionResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\LecturerQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LecturerQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $LecturerQuestions = LecturerQuestion::all();
            return $this->successResponse(LecturerQuestionResource::collection($LecturerQuestions), 'Lecturer Questions retrieved successfully.');
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
                'lecturer_element_id' => 'required|exists:lecturer_elements,id',
            ]);


            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $LecturerQuestion = LecturerQuestion::create($input);

            return $this->successResponse(new LecturerQuestionResource($LecturerQuestion), 'Lecturer Question created successfully.', 201);
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
            $LecturerQuestion = LecturerQuestion::find($id);

            if (is_null($LecturerQuestion)) {
                return $this->errorResponse('Lecturer Question not found.', [], 404);
            }

            return $this->successResponse(new LecturerQuestionResource($LecturerQuestion), 'Lecturer Question retrieved successfully.');
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
            $LecturerQuestion = LecturerQuestion::find($id);

            if (is_null($LecturerQuestion)) {
                return $this->errorResponse('Lecturer Question not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'question' => 'required',
                'min_range' => 'required',
                'max_range' => 'required',
                'label' => 'required|array',
                'lecturer_element_id' => 'required|exists:lecturer_elements,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $range = $input['max_range'] - $input['min_range'] + 1;
            if (count($input['label']) > $range || count($input['label']) < $range) {
                return $this->errorResponse('The label is invalid. The label must be equal to the range.', [], 422);
            }

            $input['label'] = implode(',', $input['label']);
            $LecturerQuestion->question = $input['question'];
            $LecturerQuestion->min_range = $input['min_range'];
            $LecturerQuestion->max_range = $input['max_range'];
            $LecturerQuestion->label = $input['label'];
            $LecturerQuestion->lecturer_element_id = $input['lecturer_element_id'];
            $LecturerQuestion->save();

            return $this->successResponse(new LecturerQuestionResource($LecturerQuestion), 'Lecturer Question updated successfully.');
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
            $LecturerQuestion = LecturerQuestion::find($id);

            if (is_null($LecturerQuestion)) {
                return $this->errorResponse('Lecturer Question not found.', [], 404);
            }

            $LecturerQuestion->delete();

            return $this->successResponse([], 'Lecturer Question deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
