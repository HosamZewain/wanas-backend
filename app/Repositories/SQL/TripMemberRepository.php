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
            dd($trip);
            $filters['UserId'] = $memberId;
            $filters['TripId'] = $tripId;
            $filters['StatusIn'] = [TripMember::STATUS_APPROVED, TripMember::STATUS_DISAPPROVED];
            $check =  app(__CLASS__)->search($filters, [], false, false, false);
            if (count($check)) {
                return true;
            }
//            return (bool)$trip->members->where(function ($query) use ($memberId, $tripId) {
//                $query->where('user_id', $memberId);
//                $query->where('trip_id', $tripId);
//                $query->whereIn('status', [TripMember::STATUS_APPROVED, TripMember::STATUS_DISAPPROVED]);
//            })->exists();
        }

        return false;
    }
}
