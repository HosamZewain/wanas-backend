<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use ModelTrait;

    protected $table = 'settings';
    protected $fillable = [
        'app_name',
        'logo',
        'mobile',
        'email',
        'about',
    ];

    /***************scopes******************/

    /***************relations**************/

    /***************attributes******************/
}
