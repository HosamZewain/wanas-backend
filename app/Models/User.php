<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, ModelTrait;

    public const ACTIVE = 1;
    public const NOT_ACTIVE = 0;

    public const TYPE_USER = 1;
    public const TYPE_ADMIN = 2;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    protected $filters = ['Type', 'UnConfirmed'];
    protected $appends = [ 'UnConfirmed'];
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'gender',
        'civil_image',
        'profile_image',
        'gender',
        'status',
        'birth_date',
        'activation_code',
        'password',
        'type',
        'notifications',
        'civil_image_front',
        'civil_image_back',
        'rate',
        'country_id',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*****************scopes********************/
    public function scopeOfType($query, $value)
    {
        return $query->where('type', $value);
    }

    public function scopeOfUnConfirmed($query, $value)
    {
        return $query->whereHas('attachments', function ($query) use ($value) {
            $query->where('status', Attachment::STATUS_UPLOADED);
        });
    }

    /*****************relations*****************/
    public function vehicle(): HasOne
    {
        return $this->hasOne(UserVehicle::class, 'user_id');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, 'user_id');
    }

    public function rates(): HasMany
    {
        return $this->hasMany(UserRate::class, 'rate_user_id');
    }
    public function Notification(): MorphMany
    {
        return $this->morphMany(Notification::class, 'model');
    }

    public function fcmTokens(): HasMany
    {
        return $this->hasMany(UserFcmToken::class, 'user_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    /***************attributes******************/

    public function getIsMemberAttribute()
    {

    }

    public function getUnConfirmedAttribute()
    {
        return (bool)$this->whereHas('attachments', function ($query) {
            $query->where('status', Attachment::STATUS_UPLOADED);
        });
    }
}
