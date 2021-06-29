<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Repositories\SQL\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends ApiBaseController
{

    public $IUserRepository;

    public function __construct(UserRepository $UserRepo)
    {
        $this->IUserRepository = $UserRepo;
        parent::__construct($UserRepo, UserResource::class);
    }

    public function logout(Request $request)
    {
        $resource = $request->user();
        if (count($resource->fcmTokens)) {
            $resource->fcmTokens()->delete();
        }
        if ($resource) {
            $resource = new UserResource($request->user());
            return $this->respondWithSuccess(__('messages.log_out_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function login(Request $request)
    {
        $messages = [
            'mobile.required' => 'رقم الهاتف مطلوب',
            'fcm_token.required' => 'fcm token مطلوب',
            'mobile.exists' => 'رقم الهاتف غير مسجل من قبل ، يرجى تسجيل حساب جديد',
            'password.required' => 'كلمة المرور  مطلوبة',
            'password.confirmed' => 'تأكيد كلمة  المرور  مطلوب',
            'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 أرقام وحروف',
        ];
        $validation = Validator::make($request->all(), [
            'mobile' => 'required|exists:users,mobile',
            'password' => 'required|min:8',
            'fcm_token' => 'required',
        ], $messages);


        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }


        $resource = $this->IUserRepository->findBy('mobile', $request->mobile);
        $token = $resource->createToken('auth_token')->plainTextToken;
        $resource['access_token'] = $token;
        $resource['token_type'] = 'Bearer';
        if ($resource) {
            if ($resource->status == User::NOT_ACTIVE) {
                return $this->respondWithErrors(__('messages.account_not_active'), 401, $resource, __('messages.account_not_active'));
            }
            if (Hash::check($request->password, $resource->password)) {
                $resource->fcmTokens()->create([
                    'token' => $request->fcm_token,
                ]);
                $resource = new UserResource($resource);
                return $this->respondWithSuccess(__('messages.login_success'), $resource);
            }
            return $this->respondWithErrors(__('auth.failed'), 400, null, __('auth.failed'));
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        $resource = $request->user();
        $messages = [
            'mobile.required' => 'رقم الهاتف مطلوب',
            'mobile.exists' => 'رقم الهاتف غير مسجل من قبل ، يرجى تسجيل حساب جديد',
            'password.required' => 'كلمة المرور  مطلوبة',
            'password.confirmed' => 'تأكيد كلمة  المرور  مطلوب',
            'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 أرقام وحروف',
        ];
        $validation = Validator::make($request->all(), [
            'mobile' => 'nullable|unique:users,mobile,' . $resource->id,
            'password' => 'nullable|confirmed|min:8',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        if ($request->get('name')) {
            $resource->update(['name' => $request->name]);
        }
        if ($request->get('mobile')) {
            $resource->update(['mobile' => $request->mobile]);
        }
        if ($request->get('gender')) {
            $resource->update(['gender' => $request->gender]);
        }
        if ($request->hasFile('civil_image')) {
            $resource->update(['civil_image' => $request->file('civil_image')->store('users', 'public'),]);
        }
        if ($request->hasFile('profile_image')) {
            $resource->update(['profile_image' => $request->file('profile_image')->store('users', 'public'),]);
        }
        if ($request->get('birth_date')) {
            $resource->update(['birth_date' => $request->birth_date]);
        }
        if ($request->get('notifications')) {
            $resource->update(['notifications' => $request->notifications]);
        }
        if ($request->get('status')) {
            $resource->update(['status' => $request->status]);
        }
        if ($request->get('password')) {
            $resource->update(['password' => Hash::make($request->password)]);
        }
        $resource->save();
        if ($resource) {
            $resource = new UserResource($resource);
            return $this->respondWithSuccess(__('messages.data_found'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'mobile.required' => 'رقم الهاتف مطلوب',
            'mobile.exists' => 'رقم الهاتف غير مسجل من قبل ، يرجى تسجيل حساب جديد',
            'password.required' => 'كلمة المرور  مطلوبة',
            'password.confirmed' => 'تأكيد كلمة  المرور  مطلوب',
            'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 أرقام وحروف',
        ];
        $validation = Validator::make($request->all(), [
            'mobile' => 'required|exists:users,mobile',
            'password' => 'required|confirmed|min:8',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }

        $user = $this->IUserRepository->findBy('mobile', $request->mobile);
        if ($request->get('password')) {
            $this->IUserRepository->update($user, ['password' => Hash::make($request->password)]);
        }
        if ($user) {
            $resource = new UserResource($user);
            return $this->respondWithSuccess(__('messages.password_changed_successfully'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }


}
