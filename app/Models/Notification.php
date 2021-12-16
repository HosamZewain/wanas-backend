<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Trip;

class Notification extends Model
{
    use ModelTrait;

    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'body',
        'to_user',
        'from_user',
        'type',
        'model_id',
        'model_type',
    ];

    /***************scopes******************/

    /***************relations**************/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user');
    }

    public function Member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    /**
     * @return BelongsTo
     */
    public function relatedModel(): BelongsTo
    {
        if ($this->model_type == 'App\Models\Trip') {
            return $this->belongsTo(Trip::class, 'model_id');
        }
        return $this->belongsTo(Trip::class, 'model_id');
    }
    /***************attributes******************/
}
