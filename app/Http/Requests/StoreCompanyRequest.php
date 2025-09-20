<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ajustar a policy/rol; provisional true
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255','unique:companies,slug'],
            'plan' => ['nullable','string','max:100'],
            'billing_email' => ['nullable','email'],
            'active_until' => ['nullable','date'],
            'trial_ends_at' => ['nullable','date'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => \Str::slug($this->input('name'))]);
        }
    }
}
