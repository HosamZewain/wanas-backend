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
    protected $appends = ['full_url'];
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


    /********attributes****************/

    public function getFullUrlAttribute(): string
    {
        return Storage::url($this->attachment_url);
    }
    /********relations****************/

}
