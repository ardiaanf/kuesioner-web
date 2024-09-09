<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudyProgramResource extends JsonResource
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
            'major_id' => $this->major_id,
            'major' => $this->major ? $this->major->name : '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
