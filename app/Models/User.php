<?php

namespace App\Models;

use App\Constants\FileConstants;
use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
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
        'name', 'email', 'password','phone','country_code','need_logout'
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
    ];
    protected array $filters = ['keyword', 'role', 'roleName', 'email'];
    public array $filterModels = ['Role'];
    public array $filterCustom = ['employmentAttachments'];
    protected array $searchable = ['name', 'email','employee.personal_email','employee.job_title'];
    public array $translatable = ['name'];

    //---------------------relations-------------------------------------
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    //---------------------relations-------------------------------------

    // ----------------------- Scopes -----------------------
    public function scopeOfRole($query, $value)
    {
        return $query->whereHas('roles', function ($query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function scopeOfRoleName($query, $value)
    {
        return $query->whereHas('roles', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }

    // ----------------------- Scopes -----------------------

    // --------------------- custom filters data -------------------
    public static function employmentAttachments(): array
    {
        return FileConstants::employmentAttachmentTypes();
    }
    // --------------------- custom filters data -------------------

    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function routeNotificationForFcm(): array|string
    {
        return $this->getDeviceTokens();
    }

    public function getDeviceTokens(): array
    {
        return $this->tokens->unique('fcm_token')->pluck('fcm_token')->toArray();
    }
}
