<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class TripRate extends Model
{
    use ModelTrait;
    protected $table = 'trip_rates';
    protected $fillable = [
        'user_id',
        'trip_id',
        'rate',
        'comment',
    ];
}
