<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'max_days' => 'integer',
        'is_active' => 'boolean',
    ];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
} 