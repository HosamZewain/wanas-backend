<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use ModelTrait,LocalizedTrait;

    protected $appends = ['LName'];

    protected $table = 'governorates';
    protected $fillable = [
        'name_ar',
        'name_en',
        'country_id',
    ];


    /********attributes****************/

    public function getLNameAttribute()
    {
        return $this->getLocalValue($this,'name');
    }

    /********relations****************/


    /********scopes****************/

}
