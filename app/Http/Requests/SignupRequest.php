<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SignupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => [
                'required','string','max:255',
                // Validación de unicidad por nombre de compañía
                Rule::unique('companies','name')
            ],
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255', Rule::unique('users','email')],
            'password' => ['required','confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.unique' => 'Este nombre de empresa ya está registrado.',
            'email.unique' => 'Este email ya está en uso.',
        ];
    }
}
