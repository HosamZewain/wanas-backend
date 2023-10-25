<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\JsonValidationTrait;

class PageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => config('validations.string.req'),
            'body' => config('validations.text.req'),
            'image' => config('validations.array.null'),
            'image.*.id' => sprintf(config('validations.model.null'), 'files'),
        ];
    }

    /**
     * Customizing input names displayed for user
     * @return array
     */
    public function attributes() : array
    {
        return [
            'title' => __json('pages.title'),
            'body' => __json('pages.body'),
            'image' => __json('pages.image'),
            'image.*.id' => __json('pages.image'),
        ];
    }

    /**
     * @return array
     */
    public function messages() : array
    {
        return [];
    }
}
