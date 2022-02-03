<?php

namespace App\Repositories\SQL;

use App\Models\User;
use App\Models\UserFcmToken;
use App\Repositories\Contracts\IUserFcmTokenRepository;
use App\Repositories\Contracts\IUserRepository;

class UserFcmTokenRepository extends AbstractModelRepository implements IUserFcmTokenRepository
{
    /**
     * @param UserFcmToken $model
     */
    public function __construct(UserFcmToken $model)
    {
        parent::__construct($model);
    }
}
