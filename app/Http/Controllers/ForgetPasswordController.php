<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserContract;
use Illuminate\Support\Facades\DB;
use Throwable;

class ForgetPasswordController extends BaseApiController
{
    /**
     * UserController constructor.
     * @param UserContract $repository
     */
    public function __construct(UserContract $repository)
    {
        parent::__construct($repository, UserResource::class, 'user');
    }

    /**
     * @param $token
     * @return mixed
     */
    public function showResetPasswordForm($token): mixed
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function submitResetPasswordForm(ForgetPasswordRequest $request): mixed
    {
        $user = app(UserContract::class)->findBy('email', $request['email']);
        DB::transaction(static function () use ($request, $user) {
            $existsInReset = app('auth.password.broker')->tokenExists($user, $request['token']);
            if (!$existsInReset) {
                return back()->withInput()->with('error', 'Invalid token!');
            }
            app('auth.password.broker')
                ->reset($request->only(['email', 'password', 'token']), function ($user, $password) {
                    $user->password = bcrypt($password);
                    $user->save();
                });
        });
        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
