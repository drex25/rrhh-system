<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'timezone',
        'currency',
        'address',
        'phone',
        'website',
        'tax_id',
        'business_type',
        'settings',
        'plan',
        'billing_email',
        'active_until',
        'trial_ends_at',
        'meta',
        'is_active',
        'industry',
        'size',
    ];

    protected $casts = [
        'active_until' => 'datetime',
        'trial_ends_at' => 'datetime',
        'meta' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        // Ajustar si decides multi-company por usuario (belongsToMany con pivot)
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
