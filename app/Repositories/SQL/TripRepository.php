<?php

namespace App\Repositories\SQL;

use App\Models\Trip;
use App\Repositories\Contracts\ITripRepository;

class TripRepository extends AbstractModelRepository implements ITripRepository
{
    /**
     * @param Trip $model
     */
    public function __construct(Trip $model)
    {
        parent::__construct($model);
    }
}
