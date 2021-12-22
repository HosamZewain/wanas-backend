<?php

namespace App\Repositories\SQL;

use App\Models\TripMember;
use App\Repositories\Contracts\ITripMemberRepository;

class TripMemberRepository extends AbstractModelRepository implements ITripMemberRepository
{
    private $tripRepository;

    /**
     * @param TripMember $model
     */
    public function __construct(TripMember $model)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->tripRepository = app(TripRepository::class);
    }

    public function checkForMemberApproval($tripId, $memberId): bool
    {
        $check = $this->model->where('user_id', $memberId)->where('trip_id', $tripId)->first();
        if ($check) {
            return $check->status == TripMember::STATUS_APPROVED;
        }
        return false;
    }
}
