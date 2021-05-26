<?php

namespace App\Repositories\SQL;

use App\Models\TripMember;
use App\Repositories\Contracts\ITripMemberRepository;

class TripMemberRepository extends AbstractModelRepository implements ITripMemberRepository
{
    /**
     * @param TripMember $model
     */
    public function __construct(TripMember $model)
    {
        parent::__construct($model);
    }
}
