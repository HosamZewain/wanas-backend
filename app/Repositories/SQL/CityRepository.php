<?php

namespace App\Repositories\SQL;

use App\Models\City;
use App\Repositories\Contracts\ICityRepository;

class CityRepository extends AbstractModelRepository implements ICityRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
