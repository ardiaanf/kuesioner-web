<?php

namespace App\Http\Resources\Dosen;

use App\Http\Resources\Dosen\LecturerElementResource;
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
            'admin' => $this->whenLoaded('admin', function () {
                return $this->admin->name;
            }),
            'lecturer_elements' => LecturerElementResource::collection($this->whenLoaded('lecturerElements')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
