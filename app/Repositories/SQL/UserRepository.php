<?php

namespace App\Repositories\SQL;

use App\Constants\FileConstants;
use App\Models\User;
use App\Repositories\Contracts\FileContract;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserContract
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function syncRelations($attributes, $model): void
    {
        if (isset($attributes['role_id']) ) {
            $model->syncRoles($attributes['role_id']);
        }
    }

    public function updateToken($attributes, $model)
    {
        $fcm = $this->model->tokens()->where('fcm_token', $attributes['fcm_token'])->first();
        if (!$fcm) {
            $token = $model->createToken('web', $attributes);
            $token->accessToken->fcm_token = $attributes['fcm_token'];
            $token->accessToken->save();
        }
        return $model->refresh();
    }

    public function createMigratedUser($record, $JsonName = null): mixed
    {
        if (is_null($JsonName)) {

            $JsonName = [
                'ar' => $record->name,
                'en' => $record->name,
            ];
        }
        
        return parent::create([
            'name' => $JsonName,
            'email' => $record->email,
            'phone' => $record->phone,
            'password' => $record->password,
            'remember_token' => $record->remember_token,
            'created_at' => $record->created_at,
            'updated_at' => $record->updated_at,
        ]);
    }


}
