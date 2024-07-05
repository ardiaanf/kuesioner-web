<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'name' => $this->name,
            'reg_number' => $this->reg_number,
            'email' => $this->email,
            'password' => $this->password,
            'semester' => $this->semester,
            'major' => $this->major ? $this->major->name : null,
            'study_program' => $this->studyProgram ? $this->studyProgram->name : null,
            'student_class' => $this->studentClass ? $this->studentClass->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
