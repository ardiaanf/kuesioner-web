<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LecturerElementResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\LecturerElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LecturerElementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $LecturerElements = LecturerElement::all();
            return $this->successResponse(LecturerElementResource::collection($LecturerElements), 'Lecturer Elements retrieved successfully.');
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
            // var_dump($input);

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
                'lecturer_questionnaire_id' => 'required|exists:lecturer_questionnaires,id',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $LecturerElement = LecturerElement::create($input);

            return $this->successResponse(new LecturerElementResource($LecturerElement), 'Lecture Element created successfully.', 201);
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
            $LectureElement = LecturerElement::with('lecturerQuestions')->find($id);

            if (is_null($LectureElement)) {
                return $this->errorResponse('Lecture Element not found.', [], 404);
            }

            return $this->successResponse(new LecturerElementResource($LectureElement), 'Lecture Element retrieved successfully.');
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
            // Muat relasi lecturerQuestions dan lecturerQuestionnaire
            $LectureElement = LecturerElement::with(['lecturerQuestions', 'lecturerQuestionnaire'])->find($id);

            if (is_null($LectureElement)) {
                return $this->errorResponse('Lecture Element not found.', [], 404);
            }

            // Tambahkan nama kuesioner ke dalam respons
            $lecturerQuestionnaireName = $LectureElement->lecturerQuestionnaire ? $LectureElement->lecturerQuestionnaire->name : 'Tidak ada kuesioner';

            // Mengembalikan respons dengan status 200 dan data yang benar
            return $this->successResponse(new LecturerElementResource($LectureElement), 'Lecture Element retrieved successfully.', [
                'lecturer_questionnaire_id' => $LectureElement->lecturer_questionnaire_id,
                'lecturer_questionnaire_name' => $lecturerQuestionnaireName,
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
            $LecturerElement = LecturerElement::find($id);

            if (is_null($LecturerElement)) {
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

            // Update fields
            $LecturerElement->name = $input['name'];
            $LecturerElement->description = $input['description'];
            $LecturerElement->lecturer_questionnaire_id = $input['lecturer_questionnaire_id']; // Tambahkan ini
            $LecturerElement->save();

            return $this->successResponse(new LecturerElementResource($LecturerElement), 'Lecturer Element updated successfully.');
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
            $LectureElement = LecturerElement::find($id);

            if (is_null($LectureElement)) {
                return $this->errorResponse('Lecturer Element not found.', [], 404);
            }

            $LectureElement->delete();

            return $this->successResponse([], 'Lecturer Element deleted successfully.');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
