<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'pickup_address' => $this->pickup_address,
            'drop_off_address' => $this->drop_off_address,
            'trip_date' => $this->trip_date,
            'trip_time' => $this->trip_time,
            'status' => $this->status,
            'status_text' => __('messages.trip_status')[$this->status],
            'members_count' => $this->members_count,
            'trip_cost_per_person' => $this->trip_cost_per_person,
            'total_trip_cost' => $this->total_trip_cost,
            'rate' => $this->rate,
            'user' => new UserResource($this->user),
        ];
    }
}
