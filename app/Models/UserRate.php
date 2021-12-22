<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRate extends Model
{
    use ModelTrait;

    protected $table = 'user_rates';
    protected $filters = ['UserId'];
    protected $fillable = [
        'user_id',
        'rate',
        'comment',
    ];


    /********************scopes***************/

    public function scopeOfUserId($query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        return $query->where('user_id', $value);
    }

    /********************relations***************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
