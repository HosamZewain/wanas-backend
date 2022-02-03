<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use ModelTrait;


    public const STATUS_APPROVED = 1;
    public const STATUS_DISAPPROVED = 2;
    public const STATUS_UPLOADED = 3;
    protected $appends = ['full_url', 'status_translated'];
    protected $filters = ['StatusIn', 'ModelId','ModelClass'];
    protected $table = 'attachments';
    protected $fillable = [
        'attachment_url',
        'attachmentable_id',
        'attachmentable_type',
        'original_name',
        'key',
        'file_type',
        'status',
        'status_text',
    ];

    /********scopes****************/
    public function scopeOfStatusIn($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->whereIn('status', $value);
    }

    public function scopeOfModelId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('attachmentable_id', $value);
    }
    public function scopeOfModelClass($query, $value)
    {
        if (empty($value)) {
            return $query;
        }
        return $query->where('attachmentable_type', $value);
    }

    /********attributes****************/

    public function getFullUrlAttribute(): string
    {
        return Storage::url($this->attachment_url);
    }

    public function getStatusTranslatedAttribute(): string
    {
        return __('enums.attachment_status')[$this->status];
    }
    /********relations****************/

}
