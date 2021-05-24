<?php

namespace App\Repositories\SQL;

use App\Models\UserVehicle;
use App\Repositories\Contracts\IUserVehicleRepository;

class UserVehicleRepository extends AbstractModelRepository implements IUserVehicleRepository
{
    /**
     * @param UserVehicle $model
     */
    public function __construct(UserVehicle $model)
    {
        parent::__construct($model);
    }
}
