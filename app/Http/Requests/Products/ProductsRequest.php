<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'name_ar' => 'required | min:3 | max:100 | unique:sections,name->ar,'.$this -> id,
            'name_en' => 'required | min:3 | max:100 | unique:sections,name->en,'.$this -> id,
            'note' => 'max:255',
            'section' => 'required | integer',
        ];
    }

    public function messages()
    {
        return [

            'name_ar.required' => trans('validation.required'),
            'name_ar.min' => trans('validation.min'),
            'name_ar.max' => trans('validation.max'),
            'name_en.required' => trans('validation.required'),
            'name_en.min' => trans('validation.min'),
            'name_en.max' => trans('validation.max'),
            'note.max' => trans('validation.max'),
            'section.required' => trans('validation.required'),
            'section.integer' => trans('validation.required'),
        ];
    }
}
