<?php

namespace App\Repositories\SQL;

use App\Models\UserRate;
use App\Repositories\Contracts\IUserRateRepository;

class UserRateRepository extends AbstractModelRepository implements IUserRateRepository
{
    /**
     * @param UserRate $model
     */
    public function __construct(UserRate $model)
    {
        parent::__construct($model);
    }
}
