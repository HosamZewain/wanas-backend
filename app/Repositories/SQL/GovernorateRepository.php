<?php

namespace App\Repositories\SQL;

use App\Models\Color;
use App\Models\Governorate;
use App\Repositories\Contracts\IColorRepository;
use App\Repositories\Contracts\IGovernorateRepository;

class GovernorateRepository extends AbstractModelRepository implements IGovernorateRepository
{
    public function __construct(Governorate $model)
    {
        parent::__construct($model);
    }
}
