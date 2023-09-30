<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class TransferValidate extends FormRequest
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
            'to_phone' => 'required',
            'amount' => 'required|min:1000|integer',
        ];
    }

    public function messages() {
        return [
            'to_phone.required' => 'Phone number is required',
            'amount.required' => 'Money amount is required',
            'amount.min' => 'Money amount should be at least 1000 mmk'
        ];
    }
}
