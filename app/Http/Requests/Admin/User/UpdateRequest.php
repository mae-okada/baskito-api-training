<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'            => ['required', 'string', 'max:25'],
            'last_name'             => ['required', 'string', 'max:25'],
            'email'                 => ['required', 'string', 'email:filter', 'max:50', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'owner'                 => ['required', 'boolean'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable', 'required_with:password', 'string', 'min:8'],
        ];
    }
}
