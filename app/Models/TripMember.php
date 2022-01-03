<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripMember extends Model
{
    use ModelTrait;

    public const STATUS_APPROVED = 1;
    public const STATUS_WAITING_APPROVAL = 2;
    public const STATUS_DISAPPROVED = 3;
    protected $table = 'trip_members';
    protected $fillable = [
        'user_id',
        'trip_id',
        'status',
    ];


    protected $filters = ['PickUpAddress', 'DropOffAddress', 'Date', 'UserId', 'TripId'];


    /******************scopes******************/

    public function scopeOfUserId($query, $value)
    {
        return $query->where('to_user', $value);
    }

    public function scopeOfTripId($query, $value)
    {
        return $query->where('trip_id', $value);
    }


    /************relations*************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
