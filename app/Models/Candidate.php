<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'status',
        'job_posting_id',
        'notes',
        'interview_date',
        'interview_type',
        'interview_location',
        'interview_notes',
        'technical_test_path',
        'technical_test_score',
        'reference_check_notes',
        'preoccupational_test_date',
        'preoccupational_test_location',
        'offer_details',
        'offer_accepted_at',
        'hired_at',
        'rejection_reason',
        'withdrawn_reason',
        'calendly_link',
        'meet_link',
        'interviewer_name',
        'years_of_experience',
        'education_level',
        'current_position',
        'current_company',
        'expected_salary',
        'cover_letter',
        'source',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
        'offer_accepted_at' => 'datetime',
        'hired_at' => 'datetime',
        'preoccupational_test_date' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWING = 'reviewing';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_INTERVIEW_SCHEDULED = 'interview_scheduled';
    const STATUS_INTERVIEWED = 'interviewed';
    const STATUS_TECHNICAL_TEST = 'technical_test';
    const STATUS_REFERENCE_CHECK = 'reference_check';
    const STATUS_PREOCCUPATIONAL = 'preoccupational';
    const STATUS_OFFERED = 'offered';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_HIRED = 'hired';
    const STATUS_REJECTED = 'rejected';
    const STATUS_WITHDRAWN = 'withdrawn';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Postulación Pendiente',
            self::STATUS_REVIEWING => 'En Revisión',
            self::STATUS_SHORTLISTED => 'Preseleccionado',
            self::STATUS_INTERVIEW_SCHEDULED => 'Entrevista Programada',
            self::STATUS_INTERVIEWED => 'Entrevistado',
            self::STATUS_TECHNICAL_TEST => 'Prueba Técnica',
            self::STATUS_REFERENCE_CHECK => 'Verificación de Referencias',
            self::STATUS_PREOCCUPATIONAL => 'Examen Preocupacional',
            self::STATUS_OFFERED => 'Oferta Extendida',
            self::STATUS_ACCEPTED => 'Oferta Aceptada',
            self::STATUS_HIRED => 'Contratado',
            self::STATUS_REJECTED => 'No Aplicar',
            self::STATUS_WITHDRAWN => 'Retirado',
        ];
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_REVIEWING => 'blue',
            self::STATUS_SHORTLISTED => 'purple',
            self::STATUS_INTERVIEW_SCHEDULED => 'purple',
            self::STATUS_INTERVIEWED => 'pink',
            self::STATUS_TECHNICAL_TEST => 'orange',
            self::STATUS_REFERENCE_CHECK => 'green',
            self::STATUS_PREOCCUPATIONAL => 'yellow',
            self::STATUS_OFFERED => 'green',
            self::STATUS_ACCEPTED => 'green',
            self::STATUS_HIRED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_WITHDRAWN => 'gray',
            default => 'gray',
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'fas fa-clock',
            self::STATUS_REVIEWING => 'fas fa-search',
            self::STATUS_SHORTLISTED => 'fas fa-user-check',
            self::STATUS_INTERVIEW_SCHEDULED => 'fas fa-calendar-check',
            self::STATUS_INTERVIEWED => 'fas fa-comments',
            self::STATUS_TECHNICAL_TEST => 'fas fa-code',
            self::STATUS_REFERENCE_CHECK => 'fas fa-phone',
            self::STATUS_PREOCCUPATIONAL => 'fas fa-heartbeat',
            self::STATUS_OFFERED => 'fas fa-handshake',
            self::STATUS_ACCEPTED => 'fas fa-check-circle',
            self::STATUS_HIRED => 'fas fa-user-tie',
            self::STATUS_REJECTED => 'fas fa-times-circle',
            self::STATUS_WITHDRAWN => 'fas fa-sign-out-alt',
            default => 'fas fa-question-circle',
        };
    }

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
        $statusText = self::getStatuses()[$this->status] ?? 'Desconocido';
        $statusClass = match($this->status) {
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

        return [
            'class' => $statusClass,
            'text' => $statusText
        ];
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
