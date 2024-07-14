<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerRankingResource extends JsonResource
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
            'name' => $this->name,
            'reg_number' => $this->reg_number,
            'study_program' => $this->whenLoaded('studyPrograms', function () {
                return $this->study_program_name;
            }),
            // 'average_score' => $this->average_score,
            'average_theory' => $this->average_theory,
            'average_practicum' => $this->average_practicum,
        ];
    }
}
