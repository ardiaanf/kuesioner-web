<?php

namespace App\Http\Resources\Dosen;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $labels = explode(',', $this->label);
        $rangeLabels = [];

        for ($i = $this->min_range; $i <= $this->max_range; $i++) {
            $rangeLabels[] = [
                'key' => $i,
                'value' => isset($labels[$i - $this->min_range]) ? $labels[$i - $this->min_range] : 'Undefined'
            ];
        }

        return [
            'id' => $this->id,
            'question' => $this->question,
            'range_labels' => $rangeLabels,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
