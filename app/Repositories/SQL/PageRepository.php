<?php

namespace App\Repositories\SQL;

use App\Models\Page;
use App\Repositories\Contracts\IPageRepository;

class PageRepository extends AbstractModelRepository implements IPageRepository
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }
}
