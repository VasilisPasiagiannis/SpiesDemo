<?php

namespace App\Domains\Spies\Http\Requests;

use App\Domains\Agencies\Models\AgencyEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreApiSpyRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'agency' => ['required', 'in:' . implode(',', AgencyEnum::values())], // Validate against enum values
            'country_of_operation' => ['nullable', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'deathday' => ['nullable', 'date', 'after:date_of_birth'], // Ensure death is after birth if provided
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Το Όνομα είναι υποχρεωτικό.',
            'surname.required' => 'Το Επώνυμο είναι υποχρεωτικό.',
            'agency.in' => 'Η Εταιρεία δεν υπάρχει.',
            'country_of_operation.max' => 'Η Χώρα δεν πρέπει να είναι μεγαλύτερη από 255 χαρακτήρες.',
            'country_of_operation.string' => 'Η Χώρα δεν είναι έγκυρη.',
            'birthday.required' => 'Η Ημερομηνία Γέννησης είναι υποχρεωτική.',
            'birthday.date' => 'Η Ημερομηνία Γέννησης δεν είναι έγκυρη.',
            'deathday.after' => 'Η Ημερομηνία Θανάτου πρέπει να είναι μετά την Ημερομηνία Γέννησης.',
            'deathday.date' => 'Η Ημερομηνία Θανάτου δεν είναι έγκυρη.',
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
