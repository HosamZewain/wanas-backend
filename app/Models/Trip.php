<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Trip extends Model
{
    use ModelTrait;

    public const STATUS_ACTIVE = 1;
    public const STATUS_ENDED = 2;
    protected $table = 'trips';
    protected $appends = ['is_member', 'trip_name'];
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
        'rate',
        'from_city_id',
        'from_governorates_id',
        'to_city_id',
        'to_governorates_id'
    ];


    protected $filters = ['PickUpAddress', 'DropOffAddress', 'Date', 'FromCityId', 'ToCityId'];


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

    public function scopeOfFromCityId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereDate('from_city_id', $value);
    }

    public function scopeOfToCityId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereDate('to_city_id', $value);
    }

    /************relations*************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function ToCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function ToGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'to_governorates_id');
    }

    public function FromGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'from_governorates_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TripMember::class, 'trip_id');
    }

    public function ApprovedMembers(): HasMany
    {
        return $this->hasMany(TripMember::class, 'trip_id')->where('status', TripMember::STATUS_APPROVED);
    }

    public function TripRate(): HasMany
    {
        return $this->hasMany(TripRate::class, 'trip_id');
    }

    public function Notification(): MorphMany
    {
        return $this->morphMany(Notification::class, 'model');
    }

    /***************attributes******************/
    public function getIsMemberAttribute()
    {
        return (bool)$this->members()->where('user_id', Request()->user()->id)->whereIn('status', [TripMember::STATUS_APPROVED, TripMember::STATUS_DISAPPROVED])->first();
    }

    public function getIsNotifiationMemberAttribute()
    {
        return (bool)$this->members()->where('user_id', Request()->user()->id)->where('status', TripMember::STATUS_APPROVED)->first();
    }

    public function getTripNameAttribute()
    {
        return 'الرحلة من  (' . $this->pickup_address . ') إلى  (' . $this->drop_off_address . ')  ميعاد قيام الرحلة :  (' . $this->trip_date . '-' . $this->trip_time . ')';
    }
}
