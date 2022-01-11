<?php

namespace App\Http\Resources\Api;

use App\Models\UserVehicle;
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
            'image' => new AttachmentResource($this->attachment),
            $this->mergeWhen(($this->colorModel), [
                'color_text' => $this->colorModel->LName ?? '',
                'color_code' => $this->colorModel->color ?? '',
            ]),
            'type' => $this->type,
            'status' => $this->status,
            'is_car_verified' => (bool)($this->status == UserVehicle::STATUS_APPROVED),
            'status_text' => $this->status_text,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'car_license_front' => ($this->car_license_front) ? asset('storage/' . $this->car_license_front) : null,
            'car_license_back' => ($this->car_license_back) ? asset('storage/' . $this->car_license_back) : null,
            'driver_license_front' => ($this->driver_license_front) ? asset('storage/' . $this->driver_license_front) : null,
            'driver_license_back' => ($this->driver_license_back) ? asset('storage/' . $this->driver_license_back) : null,
            $this->mergeWhen(($this->carFront), [
                'car_front' => new AttachmentResource($this->carFront),
            ]),
            $this->mergeWhen(($this->carNear), [
                'car_near' => new AttachmentResource($this->carNear),
            ]),
            $this->mergeWhen(($this->carBack), [
                'car_back' => new AttachmentResource($this->carBack),
            ]),
        ];
    }
}
