<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\BaseApiController;

class ResetPasswordController extends BaseApiController
{
    public function sendTempPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::whereEmail($data['email'])->first();
        $newPassword = rand(10000000, 99999999);
        $user->update(['password' => $newPassword]);

        $user->notify(new ResetPasswordEmail($user,$newPassword));

        return $this->respondWithSuccess(trans('auth.reset_sent'));
    }


    public function sendCode(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', Rule::exists('users')]
        ]);

        $user = User::whereEmail($data['email'])->first();

        $user->update([

            'verification_code' => $this->generateUniqueCode()
        ]);

        Mail::to($user->email)->send(new ResetPasswordMail($user->verification_code));

        return $this->respondWithSuccess(trans('api.reset_sent'));
    }

    public function checkCode(Request $request)
    {
        $request->validate([

            'verification_code' => ['required', Rule::exists('users')]
        ]);

        $user = User::whereVerificationCode($request->verification_code)->first();

        if (!$user) {
            return $this->respondWithError(trans('messages.error_message'));
        }

        return $this->respondWithSuccess(trans('messages.success_message'));
    }

    public function changePassword($code, Request $request)
    {
        $data = $request->validate([

            'password' => ['required', 'min:3', 'confirmed:password_confirmation'],
        ]);

        $user = User::whereVerificationCode($code)->first();

        if (!$user) {
            return $this->respondWithError(trans('messages.error_message'));
        }

        $user->update($data + ['verification_code' => null]);

        return $this->respondWithSuccess(trans('messages.password_changed'));
    }

    protected function generateUniqueCode()
    {
        $codeNumber = 6;

        $code = Str::random($codeNumber);

        while (User::where('verification_code', $code)->exists()) {
            $code = Str::random($codeNumber);
        }

        return $code;
    }
}
