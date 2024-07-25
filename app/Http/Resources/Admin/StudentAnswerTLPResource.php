<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAnswerTLPResource extends JsonResource
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
            'questionnaire' => $this->studentQuestionnaire ? $this->studentQuestionnaire->name : null,
            'element' => $this->studentElement ? $this->studentElement->name : null,
            'question' => $this->studentQuestion ? $this->studentQuestion->question : null,
            'answer' => $this->answer,
        ];
    }
}
