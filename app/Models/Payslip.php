<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToCompany;

class Payslip extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'employee_id',
        'payment_date',
        'period_start',
        'period_end',
        'gross_salary',
        'net_salary',
        'deductions',
        'allowances',
        'payment_method',
        'bank_account',
        'file_path',
        'is_paid',
        'paid_at',
        'notes',
        'company_id',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
        'gross_salary' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'deductions' => 'array',
        'allowances' => 'array',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
