<?php

namespace App\Models;

use App\Constants\FileConstants;
use App\Constants\GenderConstants;
use App\Constants\UserStatusConstants;
use App\Constants\UserTypeConstants;
use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticated;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class User extends Authenticated
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait,
        HasRoles, SearchTrait, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'activation_code',
        'birth_date',
        'notification_active',
        'rate',
        'gender',
        'status',
        'type',
        'is_active',
        'need_logout'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender' => GenderConstants::class,
        'status' => UserStatusConstants::class,
        'type' => UserTypeConstants::class
    ];
    protected array $filters = ['keyword'];
    public array $filterModels = [];
    public array $filterCustom = [];
    protected array $searchable = ['name', 'email','phone'];
    public array $translatable = [];

    //---------------------relations-------------------------------------
   
    public function profileImage(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', FileConstants::PROFILE_IMAGE->value);
    }

    public function civilImage(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', FileConstants::CIVIL_IMAGE->value);
    }

    public function civilImageFront(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', FileConstants::CIVIL_IMAGE_FRONT->value);
    }

    public function civilImageBack(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', FileConstants::CIVIL_IMAGE_BACK->value);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    //---------------------relations-------------------------------------

    // ----------------------- Scopes -----------------------

    // ----------------------- Scopes -----------------------

    // --------------------- Attributes ---------------------
    
    public function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => bcrypt($value)
        );
    }
    // --------------------- Attributes ---------------------

    public function routeNotificationForFcm(): array|string
    {
        return $this->getDeviceTokens();
    }

    public function getDeviceTokens(): array
    {
        return $this->tokens->unique('fcm_token')->pluck('fcm_token')->toArray();
    }
}
