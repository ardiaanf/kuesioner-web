<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [ // Sesuaikan data yang ingin ditampilkan
            'id' => $this->id,
            'name' => $this->name,
            'reg_number' => $this->reg_number,
            'email' => $this->email,
            // Tambahkan atribut lain yang diperlukan
        ];
    }
}
