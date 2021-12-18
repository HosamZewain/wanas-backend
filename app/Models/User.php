<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    protected $filters = ['Type'];
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

    /*****************relations*****************/
    public function vehicle()
    {
        return $this->hasOne(UserVehicle::class, 'user_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'user_id');
    }

    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class, 'user_id');
    }

    /***************attributes******************/

    public function getIsMemberAttribute()
    {

    }
}
