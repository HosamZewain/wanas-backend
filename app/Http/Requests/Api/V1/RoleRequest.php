<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\JsonValidationTrait;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    use JsonValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this['new_name']){
            unset($this['name']);
            $this['name'] = $this['new_name'];
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:190',
                Rule::unique('roles')->ignore($this->id),
            ],
            'role_permissions' => 'required|array',
        ];
    }

    /**
     * Customizing input names displayed for user
     * @return array
     */
    public function attributes(): array
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [

        ];
    }
}
