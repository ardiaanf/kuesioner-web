<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
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
            'reg_number' => $this->reg_number,
            'email' => $this->email,
            'password' => $this->password,
            'gender' => $this->gender,
            'work_period' => $this->work_period,
            'employment_status' => $this->lecturerEmploymentStatus ? $this->lecturerEmploymentStatus->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
