<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceDateReportsRequest extends FormRequest
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
            'status' => 'required | integer',
            'start_date' => 'required | date | date_format:Y-m-d',
            'end_date' => 'required | date | date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
