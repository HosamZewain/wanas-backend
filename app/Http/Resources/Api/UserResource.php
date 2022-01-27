<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'mobile' => $this->mobile,
            'birth_date' => $this->birth_date,
            'status_text' => ($this->status == User::ACTIVE) ? __('messages.active') : __('messages.not_active'),
            'status' => $this->status,
            'is_verified' => $this->is_verified,
            'gender' => $this->gender,
            'rate' => round($this->rate, 2),
            $this->mergeWhen($this->country, [
                'country' => $this->country,
            ]),
            'country_id' => $this->country_id,
            'trips_count' => count($this->trips),
            'profile_image' => ($this->profile_image) ? asset('storage/' . $this->profile_image) : null,
            'civil_image' => ($this->civil_image) ? asset('storage/' . $this->civil_image) : null,
            'civil_image_front' => ($this->civil_image_front) ? asset('storage/' . $this->civil_image_front) : null,
            'civil_image_back' => ($this->civil_image_back) ? asset('storage/' . $this->civil_image_back) : null,
            'rates' => UserRateResource::collection($this->whenLoaded('rates')),
            $this->mergeWhen($this->vehicle, [
                'vehicle' => new UserVehicleResource($this->vehicle),
            ]),
            $this->mergeWhen(!empty($this->access_token), [
                'access_token' => $this->access_token,
                'token_type' => 'Bearer',
            ]),
        ];
    }
}
