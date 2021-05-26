<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

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
    public function user()
    {
        return $this->belongsTo(User::class, 'to_user');
    }
    public function Member()
    {
        return $this->belongsTo(User::class, 'from_user');
    }
    public function model()
    {
        return $this->belongsTo(get_class($this->model_type), 'model_id');
    }
    /***************attributes******************/
}
