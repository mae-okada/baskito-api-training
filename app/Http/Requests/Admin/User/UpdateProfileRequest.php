<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:25'],
            'last_name'  => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email:filter', 'max:50', 'unique:users,email,' . auth_user()?->id],
            'owner' => ['required', 'boolean'],
        ];
    }
}
