<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class JobPosting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'department_id',
        'position_id',
        'employment_type',
        'work_schedule',
        'location',
        'min_salary',
        'max_salary',
        'status',
        'application_deadline',
        'vacancies',
        'applications_count',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'application_deadline' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'vacancies' => 'integer',
        'applications_count' => 'integer'
    ];

    // Relaciones
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors & Mutators
    public function getSalaryRangeAttribute()
    {
        if ($this->min_salary && $this->max_salary) {
            return number_format($this->min_salary, 2) . ' - ' . number_format($this->max_salary, 2);
        } elseif ($this->min_salary) {
            return 'Desde ' . number_format($this->min_salary, 2);
        } elseif ($this->max_salary) {
            return 'Hasta ' . number_format($this->max_salary, 2);
        }
        return 'A convenir';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Borrador'],
            'published' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Publicada'],
            'closed' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cerrada'],
            default => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Desconocido']
        };
    }

    // Métodos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jobPosting) {
            $baseSlug = Str::slug($jobPosting->title);
            $slug = $baseSlug;
            $counter = 1;

            // Check if slug exists and append number until unique
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $jobPosting->slug = $slug;
        });
    }
}
