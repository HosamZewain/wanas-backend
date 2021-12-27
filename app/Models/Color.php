<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use ModelTrait,LocalizedTrait;

    protected $appends = ['LName'];

    protected $table = 'colors';
    protected $fillable = [
        'name_ar',
        'name_en',
        'color',
    ];


    /********attributes****************/

    public function getLNameAttribute()
    {
        return $this->getLocalValue($this,'name');
    }

    /********relations****************/


    /********scopes****************/

}
