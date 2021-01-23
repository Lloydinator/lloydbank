<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|max:72', 
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.max' => 'Too long. Please contact us if we\'ve made a mistake',
            'email.email' => 'Please enter a valid email address',
            'email.required' => 'We need your email',
            'email.unique' => 'That email address is already in our system',
            'password.required' => 'Please enter a password',
            'password.confirmed' => 'Passwords don\'t match' 
        ];
    }
}
