<?php

namespace App\Repositories\SQL;

use App\Models\ContactUs;
use App\Repositories\Contracts\IContactUsRepository;

class ContactUsRepository extends AbstractModelRepository implements IContactUsRepository
{
    public function __construct(ContactUs $model)
    {
        parent::__construct($model);
    }
}
