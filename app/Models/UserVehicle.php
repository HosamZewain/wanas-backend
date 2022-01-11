<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UserVehicle extends Model
{

    use ModelTrait;

    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_DISAPPROVED = 3;
    protected $table = 'user_vehicle';
    protected $filters = ['UserId'];
    protected $fillable = [
        'user_id',
        'color',
        'number',
        'model',
        'image',
        'type',
        'status',
        'car_license_front',
        'car_license_back',
        'driver_license_front',
        'driver_license_back',
        'notes',
    ];

    /******************attributes******************/
    public function getStatusTextAttribute()
    {
        return __('messages.trip_status');
    }

    /******************scopes******************/

    public function scopeOfUserId($query, $value)
    {
        return $query->where('user_id', $value);
    }

    /******************relations******************/

    public function VehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'type');
    }
    public function colorModel(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    public function carFront(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('key', 'car_front');
    }

    public function carNear(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('key', 'car_near');
    }

    public function carBack(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('key', 'car_back');
    }

}
