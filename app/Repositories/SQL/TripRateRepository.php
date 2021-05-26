<?php

namespace App\Repositories\SQL;

use App\Models\TripRate;
use App\Repositories\Contracts\ITripRateRepository;

class TripRateRepository extends AbstractModelRepository implements ITripRateRepository
{
    /**
     * @param TripRate $model
     */
    public function __construct(TripRate $model)
    {
        parent::__construct($model);
    }
}
