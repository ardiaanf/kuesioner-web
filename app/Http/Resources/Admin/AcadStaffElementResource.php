<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AcadStaffElementResource extends JsonResource
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
            'acad_staff_questionnaire_id' => $this->acad_staff_questionnaire_id, // Pastikan ini ada
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
