<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{

    use ModelTrait;

    protected $table = 'user_vehicle';
    protected $filters = ['UserId'];
    protected $fillable = [
        'user_id',
        'color',
        'number',
        'model',
        'image',
        'type'
    ];


    /******************scopes******************/

    public function scopeOfUserId($query, $value)
    {
        return $query->where('user_id', $value);
    }

    /******************relations******************/

    public function VehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'type');
    }
}
