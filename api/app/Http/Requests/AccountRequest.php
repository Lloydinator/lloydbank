<?php

namespace App\Http\Requests;

use App\Http\Requests\APIFormRequest;

class AccountRequest extends APIFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'phone' => 'required',
            'street' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric'
        ];
    }
}
