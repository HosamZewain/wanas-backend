<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use ModelTrait, LocalizedTrait;

    protected $appends = ['LName'];

    protected $filters = ['GovernorateId'];
    protected $table = 'cities';
    protected $fillable = [
        'name_ar',
        'name_en',
        'governorates_id',
    ];

    /******************scopes******************/

    public function scopeOfGovernorateId($query, $value)
    {
        return $query->where('governorates_id', $value);
    }
    /********attributes****************/

    public function getLNameAttribute()
    {
        return $this->getLocalValue($this, 'name');
    }

    /********relations****************/

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class,'governorates_id');
    }

}
