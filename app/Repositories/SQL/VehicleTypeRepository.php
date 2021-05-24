<?php

namespace App\Repositories\SQL;

use App\Models\VehicleType;
use App\Repositories\Contracts\IVehicleTypeRepository;

class VehicleTypeRepository extends AbstractModelRepository implements IVehicleTypeRepository
{
    /**
     * @param VehicleType $model
     */
    public function __construct(VehicleType $model)
    {
        parent::__construct($model);
    }
}
