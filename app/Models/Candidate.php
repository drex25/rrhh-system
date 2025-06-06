<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_posting_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'cover_letter',
        'status',
        'rejection_reason',
        'notes',
        'interview_schedule',
        'expected_salary',
        'current_position',
        'current_company',
        'years_of_experience',
        'education_level',
        'source',
        'is_active'
    ];

    protected $casts = [
        'interview_schedule' => 'array',
        'expected_salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_name',
        'status_badge',
    ];

    // Relaciones
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'reviewing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'shortlisted' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            'interview_scheduled' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'interviewed' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
            'technical_test' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'reference_check' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300',
            'offered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'accepted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
            'hired' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'withdrawn' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }

    // Métodos de estado
    public function canBeInterviewed()
    {
        return in_array($this->status, ['shortlisted', 'interview_scheduled', 'interviewed']);
    }

    public function canBeRejected()
    {
        return !in_array($this->status, ['hired', 'rejected', 'withdrawn']);
    }

    public function canBeHired()
    {
        return in_array($this->status, ['accepted']);
    }
}
