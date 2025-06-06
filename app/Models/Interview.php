<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'job_posting_id',
        'interviewer_id',
        'type',
        'status',
        'scheduled_at',
        'completed_at',
        'cancelled_at',
        'location',
        'meeting_link',
        'notes',
        'feedback',
        'rating'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'rating' => 'integer'
    ];

    // Relaciones
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', 'scheduled');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'rescheduled' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'phone' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'video' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            'in_person' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }
} 