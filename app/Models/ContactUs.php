<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use ModelTrait;

    protected $table = 'contact_us';
    protected $fillable = [
        'subject',
        'name',
        'email',
        'mobile',
        'body',
    ];

    /***************scopes******************/

    /***************relations**************/

    /***************attributes******************/
}
