<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRate extends Model
{
    protected $table = 'user_rates';
    protected $fillable = [
        'user_id',
        'rate',
        'comment',
    ];


    /********************relations***************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
