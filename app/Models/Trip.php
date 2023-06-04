<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Trip extends Model
{
    use ModelTrait;

    public const STATUS_ACTIVE = 1;
    public const STATUS_ENDED = 2;

    public const TYPE_RIDE = 1;
    public const TYPE_EVENT = 2;


    protected $table = 'trips';
    protected $appends = ['is_member', 'trip_title', 'booked', 'PickUpText', 'DropText'];
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
        'to_governorates_id',
        'trip_name',
        'trip_details',
        'trip_type',
        'trip_vehicle_type'
    ];
    protected $filters = ['PickUpAddress',
        'DropOffAddress',
        'Date',
        'FromCityId',
        'FromCityIdSearch',
        'FromGovernorateId',
        'ToGovernorateId',
        'Dates',
        'ToCityId',
        'ToCityIdSearch',
        'TripType',
        'Gender',
        'StatusByDate'];
    /************scopes****************/

    public function scopeOfGender($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereHas('user',function($query , $value){
            return $query->where('gender', $value);
        });
    }

    public function scopeOfDate($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereDate('trip_date', $value);
    }

    public function scopeOfDates($query, $value)
    {
        if (!isset($value[0])) {
            return $query;
        }
        return $query->whereBetween('trip_date', [$value[0], $value[1]]);
    }

    public function scopeOfTripType($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('trip_type', $value);
    }

    public function scopeOfStatusByDate($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereRaw('concat(trip_date," ",trip_time) >= "' . $value . '"');
    }

    public function scopeOfPickUpAddress($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('pickup_address', 'LIKE', '"%' . $value . '%"')
            ->orWhereHas('fromCity', function ($query) use ($value) {
                $query->where('name_ar', 'LIKE', '%' . $value . '%')->orwhere('name_en', 'LIKE', '%' . $value . '%');
            });
    }

    public function scopeOfDropOffAddress($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('drop_off_address', 'LIKE', '%' . $value . '%')
            ->orWhereHas('ToCity', function ($query) use ($value) {
                $query->where('name_ar', 'LIKE', '%' . $value . '%')->orwhere('name_en', 'LIKE', '%' . $value . '%');
            });
    }


    public function scopeOfFromCityId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query->where('from_city_id', $value);
    }

    public function scopeOfFromGovernorateId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereHas('fromCity', function ($query) use ($value) {
            $query->where('governorates_id', $value);
        });
    }

    public function scopeOfToGovernorateId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereHas('ToCity', function ($query) use ($value) {
            $query->where('governorates_id', $value);
        });
    }

    public function scopeOfFromCityIdSearch($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query->where('from_city_id', 'LIKE', '%' . $value . '%')->whereHas('fromCity', function ($query) use ($value) {
            $query->where('name_ar', 'LIKE', '%' . $value . '%');
            $query->Orwhere('name_en', 'LIKE', '%' . $value . '%');
        });
    }

    public function scopeOfToCityId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('to_city_id', $value);
    }

    public function scopeOfToCityIdSearch($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('to_city_id', 'LIKE', '%' . $value . '%')->whereHas('ToCity', function ($query) use ($value) {
            $query->where('name_ar', 'LIKE', '%' . $value . '%');
            $query->Orwhere('name_en', 'LIKE', '%' . $value . '%');
        });
    }

    /************relations*************/
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

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
    public function getPickUpTextAttribute()
    {
        return ($this->fromCity->LName ?? '') . ',' . $this->pickup_address;
    }

    public function getDropTextAttribute()
    {
        return ($this->ToCity->LName ?? '') . ',' . $this->drop_off_address;
    }

    public function getIsMemberAttribute()
    {
        if (request()->user()) {
            return (bool)$this->members()->where('user_id', Request()->user()->id)->whereIn('status', [TripMember::STATUS_APPROVED, TripMember::STATUS_DISAPPROVED])->first();
        }
        return false;
    }

    public function getBookedAttribute()
    {
        if (request()->user()) {
            return (bool)$this->members()->where('user_id', Request()->user()->id)->exists();
        }
        return false;
    }

    public function getIsNotifiationMemberAttribute()
    {
        if (request()->user()) {
            return (bool)$this->members()->where('user_id', Request()->user()->id)->where('status', TripMember::STATUS_APPROVED)->first();
        }
        return false;
    }

    public function getTripTitleAttribute()
    {
        if ($this->trip_type == self::TYPE_EVENT) {
            return $this->trip_name ?? 'رحلة';
        } else {
            return ' من  '
                . ($this->fromCity->LName ?? '') . ','
                . $this->pickup_address
                . ' إلى  '
                . ($this->ToCity->LName ?? '')
                . ',' . $this->drop_off_address
                . '  ميعاد قيام الرحلة :  '
                . Carbon::parse($this->trip_date)->format('Y-m-d')
                . ' - (' . $this->trip_time . ')';
        }

    }
}
