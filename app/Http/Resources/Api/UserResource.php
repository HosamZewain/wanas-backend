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
            'rate' => (double)number_format($this->rate, 2),
            $this->mergeWhen($this->country, [
                'country' => $this->country,
            ]),
            'country_id' => $this->country_id,
            'trips_count' => count($this->trips),
            'civil_image' => ($this->civil_image) ? asset('storage/' . $this->civil_image) : null,
            'rates' => UserRateResource::collection($this->whenLoaded('rates')),
            $this->mergeWhen($this->vehicle, [
                'vehicle' => new UserVehicleResource($this->vehicle),
            ]),
            $this->mergeWhen(!is_null($civil_image_front = new AttachmentResource($this->attachments()->where('key', 'civil_image_front')->first())), [
                'civil_image_front' => asset($civil_image_front['full_url'] ?? null),
                'civil_image_front_status' =>$civil_image_front['status'] ?? null,
                'civil_image_front_status_text' =>$civil_image_front['status_text'] ?? null,
            ]),
            $this->mergeWhen(!is_null($civil_image_back = new AttachmentResource($this->attachments()->where('key', 'civil_image_back')->first())), [
                'civil_image_back' => asset($civil_image_back['full_url'] ?? null),
                'civil_image_back_status' =>$civil_image_back['status'] ?? null,
                'civil_image_back_status_text' =>$civil_image_back['status_text'] ?? null,
            ]),
            $this->mergeWhen(!is_null($profile_image = new AttachmentResource($this->attachments()->where('key', 'profile_image')->first())), [
                'profile_image' => asset($profile_image['full_url'] ?? null),
                'profile_image_status' =>$profile_image['status'] ?? null,
                'profile_image_status_text' =>$profile_image['status_text'] ?? null,
            ]),
            $this->mergeWhen(!empty($this->access_token), [
                'access_token' => $this->access_token,
                'token_type' => 'Bearer',
            ]),
        ];
    }
}
