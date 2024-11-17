<?php

namespace App\Domains\Spies\Http\Requests;

use App\Domains\Agencies\Models\AgencyEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class GetApiSpyRequest extends FormRequest
{
    public function authorize(): bool
    {
        if(Auth::user()->canApi()){
            return true;
        }
        return false;
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
