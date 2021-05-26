<?php

namespace App\Repositories\SQL;

use App\Models\Setting;
use App\Repositories\Contracts\ISettingRepository;

class SettingRepository extends AbstractModelRepository implements ISettingRepository
{

    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }
}
