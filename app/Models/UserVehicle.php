<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{

    protected $table = 'user_vehicle';
    protected $fillable = [
        'user_id',
        'color',
        'number',
        'model',
        'image',
        'type'
    ];
}
