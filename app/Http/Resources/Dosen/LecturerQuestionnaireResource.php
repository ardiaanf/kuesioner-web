<?php

namespace App\Http\Resources\Dosen;

use App\Http\Resources\Tendik\AcadStaffElementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerQuestionnaireResource extends JsonResource
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
            'description' => $this->description,
            'type' => $this->type,
            'acad_staff_elements' => AcadStaffElementResource::collection($this->whenLoaded('acadstaffElements')),
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
