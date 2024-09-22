<?php

namespace App\Http\Requests\Invoices;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
            'number' => 'required | min:3 | max:100 | unique:invoices,number,'.$this -> id,
            'date' => 'required | date | date_format:Y-m-d',
            'due_date' => 'required | date | date_format:Y-m-d',
            'section' => 'required | integer',
            'product' => 'required | integer',
            'collection_amount' => 'required | numeric | min:3 | max:100000000',
            'commission_amount' => 'required | numeric | min:3 | max:100000000',
            'discount' => 'required | numeric | max:100000000',
            'vat' => 'required',
            'vat_value' => 'required | numeric | max:100000000',
            'total' => 'required | numeric | max:100000000',
            'attachments' => 'mimes:pdf,jpeg,png,jpg | max:3584',
            'note' => 'max:255',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
