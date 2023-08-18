<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'                  => 'required|max:50',
            'email'                 => 'required|email:rfc,dns|unique:users',
            'password'              => 'required|confirmed|min:6',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        $nameParts = explode(' ', $validatedData['name'], 2);
        $validatedData['first_name'] = $nameParts[0] ?? '';
        $validatedData['last_name'] = $nameParts[1] ?? '';

        return $validatedData;
    }
}
