<?php

namespace App\Repositories\Contracts;

interface ITripMemberRepository extends IModelRepository
{

    public function checkForMemberApproval($tripId, $memberId);
}
