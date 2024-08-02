<?php

namespace App\Http\Resources\Dosen;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerAnswerResource extends JsonResource
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
            'lecturer_questionnaire' => $this->lecturer_questionnaire,
            'lecturer_name' => $this->lecturer_name,
            'answers' => $this->answers,
            'created_at' => $this->created_at,
        ];
    }
}
