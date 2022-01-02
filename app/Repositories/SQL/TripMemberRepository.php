<?php

namespace App\Repositories\SQL;

use App\Models\TripMember;
use App\Repositories\Contracts\ITripMemberRepository;

class TripMemberRepository extends AbstractModelRepository implements ITripMemberRepository
{
    private $tripRepository;

    public function __construct(TripMember $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->tripRepository = app(TripRepository::class);
    }

    public function checkForMemberApproval($notificationId, $tripId, $memberId): bool
    {
        $trip = $this->tripRepository->find($tripId, ['members']);
        if ($trip) {
            $check = $trip->members->where('user_id', $memberId)->where('trip_id', $tripId)->first();
            if ($check) {
                return in_array($check->status, [TripMember::STATUS_APPROVED, TripMember::STATUS_DISAPPROVED]);
            }
        }

        return false;
    }
}
