<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company')?->id;
        return [
            'name' => ['sometimes','string','max:255'],
            'slug' => ['sometimes','string','max:255', Rule::unique('companies','slug')->ignore($companyId)],
            'plan' => ['sometimes','string','max:100'],
            'billing_email' => ['sometimes','email'],
            'active_until' => ['sometimes','date'],
            'trial_ends_at' => ['sometimes','date'],
            'is_active' => ['sometimes','boolean'],
        ];
    }
}
