<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use ModelTrait;

    public const STATUS_ACTIVE = 1;
    public const STATUS_ENDED = 2;
    protected $table = 'trips';
    protected $appends = ['is_member'];
    protected $fillable = [
        'user_id',
        'pickup_address',
        'drop_off_address',
        'trip_date',
        'trip_time',
        'status',
        'members_count',
        'trip_cost_per_person',
        'total_trip_cost',
        'rate'
    ];


    protected $filters = ['PickUpAddress', 'DropOffAddress', 'Date'];


    /************scopes****************/
    public function scopeOfPickUpAddress($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('pickup_address', 'LIKE', '%' . $value . '%');
    }

    public function scopeOfDropOffAddress($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('drop_off_address', 'LIKE', '%' . $value . '%');
    }

    public function scopeOfDate($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereDate('trip_date', $value);
    }

    /************relations*************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->hasMany(TripMember::class, 'trip_id');
    }

    public function TripRate()
    {
        return $this->hasMany(TripRate::class, 'trip_id');
    }

    /***************attributes******************/
    public function getIsMemberAttribute()
    {
        return (bool)$this->members()->where('user_id', Request()->user()->id)->first();
    }
}
