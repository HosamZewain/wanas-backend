<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Repositories\SQL\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function login(Request $request)
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


        $resource = $this->IUserRepository->findBy('mobile', $request->mobile);
        if ($resource) {
            if ($resource->status == User::NOT_ACTIVE) {
                return $this->respondWithErrors(__('messages.account_not_active'), 401, null, __('messages.account_not_active'));
            }
            if (Hash::check($request->password, $resource->password)) {
                $token = $resource->createToken('auth_token')->plainTextToken;
                $resource['access_token'] = $token;
                $resource['token_type'] = 'Bearer';

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
        if ($request->get('password')) {
            $resource->update(['password' => Hash::make($request->password)]);
        }
        $resource->save();
        if ($resource) {
            $resource = new UserResource($request->user());
            return $this->respondWithSuccess(__('messages.data_found'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }
}
