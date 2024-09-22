<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
            'name_ar' => 'required | max:100 | unique:roles,name->ar,'.$this -> id,
            'name_en' => 'required | max:100 | unique:roles,name->en,'.$this -> id,
            'permission' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
