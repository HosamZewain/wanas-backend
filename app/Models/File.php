<?php

namespace App\Models;

use App\Constants\FileConstants;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, ModelTrait;

    protected $fillable = ["name", "ext", "url", "type", "width", "height",
        "mime", "fileable_type", "fileable_id", "duration", "user_id",
        "custom_name", 'notes'
    ];

    public $casts = [
        'type' => FileConstants::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public const PERMISSIONS_NOT_APPLIED = true;

    /**
     * Get the owning fileable model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('all', function (Builder $builder) {
            $builder->orderBy('id','Desc');
        });

        static::deleting(function ($file) { // before delete() method call this
            if(isset($file->url)){
                if (Storage::exists($file->url)) {
                    Storage::delete($file->url);
                }
            }
        });
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfUntracked($query)
    {
        return $query->whereNull('fileable_type');
    }

    public function getOriginalNameAttribute()
    {
        return $this->custom_name ?? substr($this->name, strpos($this->name, '-') + 1);
    }

    public static function getAvatarFixedImage(): string
    {
        return 'https://toppng.com/uploads/preview/icons-logos-emojis-user-icon-png-transparent-11563566676e32kbvynug.png';
    }

}
