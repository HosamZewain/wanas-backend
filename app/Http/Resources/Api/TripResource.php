<?php

namespace App\Http\Resources\Api;

use App\Models\TripMember;
use App\Repositories\SQL\TripMemberRepository;
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
            'from_city_id' => $this->from_city_id,
            'to_city_id' => $this->to_city_id,
            'status_text' => __('messages.trip_status')[$this->status],
            'members_count' => $this->members_count,
            'trip_cost_per_person' => $this->trip_cost_per_person,
            'total_trip_cost' => $this->total_trip_cost,
            'is_member' => $this->is_member,
            'booked' => $this->booked,
            'rate' => $this->rate,
            'user' => new UserResource($this->user),
            'members' => TripMemberResource::collection($this->ApprovedMembers),
            'member_approval' => $this->members()->where('status', TripMember::STATUS_WAITING_APPROVAL)->first(),
        ];
    }
}
