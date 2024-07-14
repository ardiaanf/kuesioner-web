<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAnswerACResource extends JsonResource
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
            'student_questionnaire' => $this->student_questionnaire,
            'student_name' => $this->student_name,
            'answers' => $this->answers,
            'created_at' => $this->created_at,
        ];
    }
}
