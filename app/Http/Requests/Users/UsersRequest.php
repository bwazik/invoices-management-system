<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'name' => 'required | max:100',
            'email' => 'required | max:100 | email | unique:users,email,'.$this -> id,
            'password' => 'required | min:6 | max:100',
            'password_confirm' => 'same:password',
            'status' => 'required | integer',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
