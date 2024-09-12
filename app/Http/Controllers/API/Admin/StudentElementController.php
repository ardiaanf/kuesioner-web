<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\StudentElement;
use App\Http\Resources\Admin\StudentElementResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentElementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $StudentElements = StudentElement::all();
            return $this->successResponse(StudentElementResource::collection($StudentElements), 'Student Elements retrieved successfully.');
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
                'student_questionnaire_id' => 'required|exists:student_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $StudentElement = StudentElement::create($input);

            return $this->successResponse(new StudentElementResource($StudentElement), 'Student Element created successfully.', 201);
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
            $StudentElement = StudentElement::find($id);

            if (is_null($StudentElement)) {
                return $this->errorResponse('Student Element not found.', [], 404);
            }

            return $this->successResponse(new StudentElementResource($StudentElement), 'Student Element retrieved successfully.');
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
            $StudentElement = StudentElement::with(['studentQuestions', 'studentQuestionnaire'])->find($id);

            if (is_null($StudentElement)) {
                return $this->errorResponse('Student Element not found.', [], 404);
            }

            // Ambil nama kuesioner
            $studentQuestionnaireName = $StudentElement->studentQuestionnaire ? $StudentElement->studentQuestionnaire->name : null;

            return $this->successResponse(new StudentElementResource($StudentElement), 'Student Element retrieved successfully.', [
                'student_questionnaire_id' => $StudentElement->student_questionnaire_id,
                'student_questionnaire_name' => $studentQuestionnaireName,
            ]);
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
            $StudentElement = StudentElement::find($id);

            if (is_null($StudentElement)) {
                return $this->errorResponse('Student Element not found.', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'student_questionnaire_id' => 'required|exists:student_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $StudentElement->name = $input['name'];
            $StudentElement->description = $input['description'];
            $StudentElement->save();

            return $this->successResponse(new StudentElementResource($StudentElement), 'Student Element updated successfully.');
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
            $StudentElement = StudentElement::find($id);

            if (is_null($StudentElement)) {
                return $this->errorResponse('Student Element not found.', [], 404);
            }

            $StudentElement->delete();

            return $this->successResponse([], 'Student Element deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
