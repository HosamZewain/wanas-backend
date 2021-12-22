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
            'status' => $this->status,
            'status_text' => $this->status_text,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'car_license_front'=> ($this->car_license_front) ? asset('storage/' . $this->car_license_front) : null,
            'car_license_back'=>  ($this->car_license_back) ? asset('storage/' . $this->car_license_back) : null,
            'driver_license_front'=> ($this->driver_license_front) ? asset('storage/' . $this->driver_license_front) : null,
            'driver_license_back'=>  ($this->driver_license_back) ? asset('storage/' . $this->driver_license_back) : null,
        ];
    }
}
