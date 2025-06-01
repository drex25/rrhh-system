<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeLeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'total_days',
        'used_days',
        'remaining_days',
        'year',
    ];

    protected $casts = [
        'total_days' => 'integer',
        'used_days' => 'integer',
        'remaining_days' => 'integer',
        'year' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    // Método para actualizar los días restantes
    public function updateRemainingDays()
    {
        $this->remaining_days = $this->total_days - $this->used_days;
        $this->save();
    }

    // Método para agregar días utilizados
    public function addUsedDays($days)
    {
        $this->used_days += $days;
        $this->updateRemainingDays();
    }

    // Método para remover días utilizados (cuando se cancela una licencia)
    public function removeUsedDays($days)
    {
        $this->used_days = max(0, $this->used_days - $days);
        $this->updateRemainingDays();
    }
} 