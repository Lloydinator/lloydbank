<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TxnStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'required',
			'to' => 'required',
			'amount' => 'required',
			'publictxn' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'from.required' => 'Something is very wrong with this form. Contact us',
			'to.required' => 'Who are you sending to?',
			'amount.required' => 'You need to put an amount',
            'publictxn.required' => 'Something is very wrong with this form. Contact us'
        ];
    }
}
