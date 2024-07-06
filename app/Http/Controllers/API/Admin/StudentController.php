<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Admin\StudentResource;
use App\Http\Controllers\API\BaseController as BaseController;

class StudentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return $this->successResponse(StudentResource::collection($students), 'Students retrieved successfully.');
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
            'reg_number' => 'required|unique:students,reg_number',
            'email' => 'required|email|unique:students,email',
            'password' => 'required',
            'gender' => 'required|in:male,female',
            'semester' => 'required',
            'major_id' => 'required|exists:majors,id',
            'study_program_id' => [
                'required',
                'exists:study_programs,id',
                Rule::exists('study_programs', 'id')->where(function ($query) use ($input) {
                    return $query->where('major_id', $input['major_id']);
                }),
            ],
            'student_class_id' => [
                'required',
                'exists:student_classes,id',
                Rule::exists('student_classes', 'id')->where(function ($query) use ($input) {
                    return $query->where('study_program_id', $input['study_program_id']);
                }),
            ]
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $student = Student::create([
            'name' => $input['name'],
            'reg_number' => $input['reg_number'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'gender' => $input['gender'],
            'semester' => $input['semester'],
            'major_id' => $input['major_id'],
            'study_program_id' => $input['study_program_id'],
            'student_class_id' => $input['student_class_id'],
        ]);

        return $this->successResponse(new StudentResource($student), 'Student created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        if (is_null($student)) {
            return $this->errorResponse('Student not found.', [], 404);
        }

        return $this->successResponse(new StudentResource($student), 'Student retrieved successfully.');
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
        $student = Student::find($id);

        if (is_null($student)) {
            return $this->errorResponse('Student not found.', [], 404);
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'reg_number' => 'required|unique:students,reg_number,' . $id,
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'required',
            'gender' => 'required|in:male,female',
            'semester' => 'required',
            'major_id' => 'required|exists:majors,id',
            'study_program_id' => [
                'required',
                'exists:study_programs,id',
                Rule::exists('study_programs', 'id')->where(function ($query) use ($input) {
                    return $query->where('major_id', $input['major_id']);
                }),
            ],
            'student_class_id' => [
                'required',
                'exists:student_classes,id',
                Rule::exists('student_classes', 'id')->where(function ($query) use ($input) {
                    return $query->where('study_program_id', $input['study_program_id']);
                }),
            ]
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $student->name = $input['name'];
        $student->reg_number = $input['reg_number'];
        $student->email = $input['email'];
        $student->password = bcrypt($input['password']);
        $student->gender = $input['gender'];
        $student->semester = $input['semester'];
        $student->major_id = $input['major_id'];
        $student->study_program_id = $input['study_program_id'];
        $student->student_class_id = $input['student_class_id'];
        $student->save();

        return $this->successResponse(new StudentResource($student), 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (is_null($student)) {
            return $this->errorResponse('Student not found.', [], 404);
        }

        $student->delete();

        return $this->successResponse([], 'Student deleted successfully.');
    }
}
