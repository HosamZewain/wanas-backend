<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use ModelTrait;

    public const TYPE_CONFIRM_USER = 'confirm_user';
    public const TYPE_NEW_TRIP = 'new_trip';
    public const TYPE_NEW_BOOK = 'new_book';
    public const TYPE_BOOK_APPROVED = 'book_approved';
    public const TYPE_BOOK_DISAPPROVED = 'book_disapproved';
    public const TYPE_CAR_APPROVED = 'car_approved';
    public const TYPE_CAR_DISAPPROVED = 'car_disapproved';
    public const TYPE_NOTIFY_USERS = 'notify_users';
    public const MODEL_TRIP = 'App\Models\Trip';
    public const MODEL_USER = 'App\Models\User';

    protected $filters = ['UserId','Type'];
    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'body',
        'to_user',
        'from_user',
        'type',
        'model_id',
        'model_type',
    ];

    /******************scopes******************/

    public function scopeOfUserId($query, $value)
    {
        return $query->where('to_user', $value);
    }
    public function scopeOfType($query, $value)
    {
        return $query->where('type', $value);
    }
    /***************relations**************/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user');
    }

    public function Member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function relatedModel(): MorphTo
    {
        return $this->morphTo('model');
    }

    /***************attributes******************/
}
