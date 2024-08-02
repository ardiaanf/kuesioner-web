<?php

namespace App\Http\Resources\Tendik;

use Illuminate\Http\Resources\Json\JsonResource;

class AcadstaffAnswerResource extends JsonResource
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
            'acad_staff_questionnaire' => $this->acad_staff_questionnaire,
            'acad_staff_name' => $this->acad_staff_name,
            'answers' => $this->answers,
            'created_at' => $this->created_at,
        ];
    }
}
