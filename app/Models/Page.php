<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use ModelTrait;

    protected $table = 'pages';
    protected $fillable = [
        'title',
        'body',
    ];

    /***************scopes******************/

    /***************relations**************/

    /***************attributes******************/
}
