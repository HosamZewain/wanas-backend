<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use SoftDeletes, ModelTrait, SearchTrait, SoftDeletes, HasTranslations;

    public const ADDITIONAL_PERMISSIONS = [];
    protected $fillable = [];
    protected array $filters = ['keyword'];
    protected array $searchable = ['name'];
    protected array $dates = [];
    public array $filterModels = ['Country'];
    public array $filterCustom = [];
    public array $translatable = ['name'];

    //---------------------relations-------------------------------------

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    //---------------------relations-------------------------------------

    //---------------------Scopes-------------------------------------

    //---------------------Scopes-------------------------------------

}
