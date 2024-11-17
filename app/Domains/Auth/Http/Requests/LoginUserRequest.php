<?php

namespace App\Domains\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            if(Auth::user()->canApi()){
                return true;
            }
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
