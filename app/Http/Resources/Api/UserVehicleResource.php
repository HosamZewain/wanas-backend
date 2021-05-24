<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'color' => $this->color,
            'number' => $this->number,
            'model' => $this->model,
            'image' => ($this->image) ? asset('storage/' . $this->image) : null,
            'type' => $this->type,
        ];
    }
}
