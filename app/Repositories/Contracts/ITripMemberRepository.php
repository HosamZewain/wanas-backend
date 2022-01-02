<?php

namespace App\Repositories\Contracts;

interface ITripMemberRepository extends IModelRepository
{

    public function checkForMemberApproval($notificationId, $tripId, $memberId);
}
