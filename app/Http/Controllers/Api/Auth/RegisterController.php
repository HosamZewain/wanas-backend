<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Repositories\SQL\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends ApiBaseController
{

    public $IUserRepository;

    public function __construct(UserRepository $UserRepo)
    {
        $this->IUserRepository = $UserRepo;
        parent::__construct($UserRepo, UserResource::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request)
    {
        $messages = [
            'mobile.required' => 'رقم الهاتف مطلوب',
            'mobile.unique' => 'رقم الهاتف مسجل من قبل ، يرجى إدخال رقم جديد',
            'name.required' => 'الإسم  مطلوب',
            'gender.required' => "حقل الجنس مطلوب",
            'birth_date.date' => "تاريخ الميلاد ليس تاريخًا صالحًا.",
            'password.required' => 'كلمة المرور  مطلوبة',
            'password.confirmed' => 'تأكيد كلمة  المرور  مطلوب',
            'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 أرقام وحروف',
        ];
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'gender' => 'required',
            'birth_date' => 'nullable|date',
            'password' => 'required|confirmed|min:8',
        ], $messages);

        if ($validation->fails()) {
            return $this->respondWithErrors($validation->errors(), 422, null, __('messages.complete_empty_values'));
        }


        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);
        $inputs['email'] = 'user' . random_int(1111, 9999) . '@wanes.com';
        $inputs['activation_code'] = random_int(1111, 9999);
        $inputs['status'] = User::NOT_ACTIVE;
        $resource = $this->IUserRepository->create($inputs);
        if ($resource) {
            $token = $resource->createToken('auth_token')->plainTextToken;
            $resource['access_token'] = $token;
            $resource['token_type'] = 'Bearer';

            $resource = new UserResource($resource);
            //$this->IUserRepository->sendSMS($resource); // deprecated for using firebase otp
            return $this->respondWithSuccess(__('messages.register_success'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }

    public function activateAccount(Request $request)
    {
        $request->user()->update([
            'status' => User::ACTIVE,
        ]);
        $resource = $request->user()->save();
        if ($resource) {
            $resource = new UserResource($request->user());
            return $this->respondWithSuccess(__('messages.activated_successfully'), $resource);
        }
        return $this->respondWithErrors(__('messages.error'), 422, null, __('messages.error'));
    }


}
