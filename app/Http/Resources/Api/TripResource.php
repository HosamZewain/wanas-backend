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
            'user_id' => $this->user_id ?? null,
            'pickup_address' => $this->pickup_address ?? null,
            'drop_off_address' => $this->drop_off_address ?? null,
            'trip_date' => $this->trip_date ?? null,
            'trip_time' => $this->trip_time ?? null,
            'status' => $this->status ?? null,
            'from_city_id' => $this->from_city_id ?? null,
            'from_city' => $this->fromCity->LName ?? null,
            'to_city_id' => $this->ToCity->LName ?? null,
            'status_text' => __('messages.trip_status')[$this->status],
            'members_count' => $this->members_count ?? null,
            'trip_cost_per_person' => $this->trip_cost_per_person ?? null,
            'total_trip_cost' => $this->total_trip_cost ?? null,
            'is_member' => $this->is_member ?? null,
            'booked' => $this->booked ?? null,
            'rate' => $this->rate ?? null,
            'user' => new UserResource($this->user),
            'members' => TripMemberResource::collection($this->ApprovedMembers),
            'member_approval' => $this->members()->where('status', TripMember::STATUS_WAITING_APPROVAL)->first(),
        ];
    }
}
