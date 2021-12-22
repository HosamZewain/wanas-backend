<?php

namespace App\Models;

use App\Traits\LocalizedTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use ModelTrait;

    protected $appends = ['full_url'];
    protected $table = 'attachments';
    protected $fillable = [
        'attachment_url',
        'attachmentable_id',
        'attachmentable_type',
        'original_name',
        'key',
        'file_type',
    ];


    /********attributes****************/

    public function getFullUrlAttribute()
    {
        return Storage::url($this->attachment_url);
    }
    /********relations****************/

}
