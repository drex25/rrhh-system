<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniquePerCompany implements ValidationRule
{
    public function __construct(
        private string $table,
        private string $column,
        private ?int $ignoreId = null,
        private string $primaryKey = 'id'
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->when(function() { return function_exists('company_id'); }, function($q) {
                if (company_id()) { $q->where('company_id', company_id()); }
            });

        if ($this->ignoreId) {
            $query->where($this->primaryKey, '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail(__('validation.unique'));
        }
    }
}
