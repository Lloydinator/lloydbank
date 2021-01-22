<?php

namespace App\Http\Requests;

use App\Http\Requests\APIFormRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class TxnStoreRequest extends APIFormRequest
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
			'email' => 'required|email',
			'amount' => 'required|numeric',
			'publictxn' => 'required'
        ];
    }

    public function messages(){
        return [
            'from.required' => 'Something went horribly wrong',
            'amount.required' => 'How much are you sending?'
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator){
            if ($this->sameUser()){
                $validator->errors()->add('email', 'You can\'t send money to yourself');
            }
        });
    }

    private function sameUser(){
        $to_user = User::where('email', request('email'))->select('id')->get();

        return $to_user[0]->id === Auth::id() ? true : false;
    }
}
