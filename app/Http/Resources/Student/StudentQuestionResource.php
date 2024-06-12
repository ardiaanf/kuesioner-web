<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentQuestionResource extends JsonResource
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
            'question' => $this->question,
            'min_range' => $this->min_range,
            'max_range' => $this->max_range,
            'label' => explode(',', $this->label),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
