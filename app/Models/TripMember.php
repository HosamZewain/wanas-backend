<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class TripMember extends Model
{
    use ModelTrait;

    public const STATUS_APPROVED = 1;
    public const STATUS_WAITING_APPROVAL = 2;
    public const STATUS_DISAPPROVED = 3;
    protected $table = 'trips';
    protected $fillable = [
        'user_id',
        'trip_id',
        'status',
    ];


    protected $filters = ['PickUpAddress', 'DropOffAddress', 'Date'];


    /************scopes****************/


    /************relations*************/

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
