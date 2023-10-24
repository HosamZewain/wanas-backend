<?php

namespace App\Http\Requests;

use App\Constants\RoleConstants;
use App\Traits\JsonValidationTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    use JsonValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function passedValidation()
    {
        $this->merge([
            'name' => [
                'en' => $this->name,
                'ar' => $this->name,
            ],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user.name_en' => 'required|min:2|max:200',
            'user.name_ar' => 'required|min:2|max:200',
            'user.email' => sprintf(config('validations.email.req'), 'users', 'email').",{$this->user['id']}",
            'user.phone' => config('validations.phone.req').'|'.
                sprintf(config('validations.unique'), 'users', 'phone').",{$this->user['id']}",
            'date_of_birth'=> "required|date",
            'employee_avatar' => 'nullable'
        ];

    }
}
