<?php

namespace App\Repositories\SQL;

use App\Models\Color;
use App\Repositories\Contracts\IColorRepository;

class ColorRepository extends AbstractModelRepository implements IColorRepository
{
    public function __construct(Color $model)
    {
        parent::__construct($model);
    }
}
