<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserContract;
use App\Traits\BaseApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseApiController
{

    public function __construct(UserContract $userContract)
    {
        parent::__construct($userContract, UserResource::class);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            if (!Auth::user()->customer?->is_active && !Auth::user()->employee?->is_active) {
                Auth::logout();
                return $this->errorWrongArgs(__json('messages.not_active'));
            }
            $user = $request->user()->load('roles', 'permissions', 'employee.avatar',
                'employee.user', 'customer.user', 'customer.avatar', 'tokens');
            return $this->respondWithModel($user);
        }
        return $this->errorWrongArgs('Wrong Credentials');
    }
}
