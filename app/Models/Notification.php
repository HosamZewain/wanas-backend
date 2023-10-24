<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use SoftDeletes, ModelTrait, SearchTrait, SoftDeletes, HasTranslations;
    public const ADDITIONAL_PERMISSIONS = [];
    protected $fillable = ['user_id', 'title', 'body', 'data', 'read_at',
        'redirect_id', 'redirect_type'];
    protected array $filters = ['keyword', 'user', 'read', 'unRead'];
    protected array $searchable = [];
    protected array $dates = [];
    public array $filterModels = [];
    public array $filterCustom = [];
    public array $translatable = [];
    public $casts = [
        'data' => 'array'
    ];
    public const PERMISSIONS_NOT_APPLIED = false;
    public const DISABLE_LOG = true;

    //---------------------relations-------------------------------------
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //---------------------relations-------------------------------------

    //---------------------Scopes-------------------------------------
    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }
    //---------------------Scopes-------------------------------------

}
