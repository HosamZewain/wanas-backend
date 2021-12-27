<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use ModelTrait,LocalizedTrait;

    protected $appends = ['LName'];

    protected $table = 'countries';
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'mobile_code',
    ];


    /********attributes****************/

    public function getLNameAttribute()
    {
        return $this->getLocalValue($this,'name');
    }

    /********relations****************/


    /********scopes****************/

}
