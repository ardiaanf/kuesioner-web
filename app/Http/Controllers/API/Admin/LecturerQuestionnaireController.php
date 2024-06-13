<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LecturerQuestionnaireResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\LecturerQuestionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LecturerQuestionnaireController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //
        if (Auth::user()->role = 'admin') {
            $lecturerQuestionnaires = LecturerQuestionnaire::with('admin')->get();
            return $this->successResponse(LecturerQuestionnaireResource::collection($lecturerQuestionnaires), 'Lecturer Questionnaires retrieved successfully');
        }else {
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
        if (Auth::user()->role = 'admin') {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        };

        $input['admin_id'] = Auth::user()->id;
        $lecturerQuestionnaires = LecturerQuestionnaire::create($input);

        return $this->successResponse(new LecturerQuestionnaireResource($lecturerQuestionnaires), 'lecturer Questionnaire created successfully', 201);

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
            // $letureQuestionnaires = LecturerQuestionnaire::find($id);
            $lecturerQuestionnaires = LecturerQuestionnaire::with('admin')->find($id);
            if (is_null($lecturerQuestionnaires)) {
                return $this->errorResponse('lecturer Questionnaire not found', [], 404);
            }

            return $this->successResponse(new LecturerQuestionnaireResource($lecturerQuestionnaires), 'lecturer Questionnaire retrieved successfully');
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
            // $lecturerQuestionnaire = LecturerQuestionnaire::with('lecturerElements.lecturerQuestions')->find($id);
            $lecturerQuestionnaire = LecturerQuestionnaire::with('admin')->with('lecturerElements.lecturerQuestions')->find($id);
            if (is_null($lecturerQuestionnaire)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            return $this->successResponse(new LecturerQuestionnaireResource($lecturerQuestionnaire), 'Lecturer Questionnaire retrieved successfully');
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
            $letureQuestionnaires = LecturerQuestionnaire::find($id);

            if (is_null($letureQuestionnaires)) {
                return $this->errorResponse('Student Questionnaire not found', [], 404);
            }

            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'description' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', $validator->errors(), 422);
            }

            $letureQuestionnaires->name = $input['name'];
            $letureQuestionnaires->description = $input['description'];
            $letureQuestionnaires->save();

            return $this->successResponse(new LecturerQuestionnaireResource($letureQuestionnaires), 'Lecture Questionnaire updated successfully');
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
            $lecturerQuestionnaire = LecturerQuestionnaire::find($id);

            if (is_null($lecturerQuestionnaire)) {
                return $this->errorResponse('Lecturer Questionnaire not found', [], 404);
            }

            $lecturerQuestionnaire->delete();

            return $this->successResponse([], 'Lecturer Questionnaire deleted successfully');
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
