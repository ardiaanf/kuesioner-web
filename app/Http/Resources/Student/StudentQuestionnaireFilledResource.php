<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentQuestionnaireFilledResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'major' => $this->major ? $this->major->name : null,
            'study_program' => $this->studyProgram ? $this->studyProgram->name : null,
            'student_class' => $this->studentClass ? $this->studentClass->name : null,
            'course' => $this->course ? $this->course->name : null,
            'lecturer' => $this->lecturer ? $this->lecturer->name : null,
            'student' => $this->student ? $this->student->name : null,
            'answers' => StudentAnswerTLPResource::collection($this->studentAnswerTlp),
            'created_at' => $this->created_at,
        ];
    }
}
