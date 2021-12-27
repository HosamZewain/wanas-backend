<?php

namespace App\Repositories\SQL;

use App\Models\Country;
use App\Repositories\Contracts\ICountryRepository;

class CountryRepository extends AbstractModelRepository implements ICountryRepository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
