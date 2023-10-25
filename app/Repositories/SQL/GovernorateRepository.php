<?php

namespace App\Repositories\SQL;

use App\Models\Governorate;
use App\Repositories\Contracts\GovernorateContract;

class GovernorateRepository extends BaseRepository implements GovernorateContract
{
    /**
     * GovernorateRepository constructor.
     * @param Governorate $model
     */
    public function __construct(Governorate $model)
    {
        parent::__construct($model);
    }
}
