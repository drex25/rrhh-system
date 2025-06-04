<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublicJobPostingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::query()
            ->where('status', 'published')
            ->where('is_active', true)
            ->with(['department', 'position']);

        // Filtros
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->input('department'));
        }

        if ($request->filled('modality')) {
            $query->where('modality', $request->input('modality'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('employment_type', $request->input('type'));
        }

        $jobPostings = $query->orderBy('is_featured', 'desc')
                            ->latest()
                            ->paginate(9);
        $departments = \App\Models\Department::where('is_active', true)->get();

        return view('public.job-postings.index', compact('jobPostings', 'departments'));
    }

    public function show(JobPosting $jobPosting)
    {
        if ($jobPosting->status !== 'published' || !$jobPosting->is_active) {
            abort(404);
        }

        $relatedJobs = JobPosting::where('status', 'published')
            ->where('is_active', true)
            ->where('id', '!=', $jobPosting->id)
            ->where(function($query) use ($jobPosting) {
                $query->where('department_id', $jobPosting->department_id)
                      ->orWhere('position_id', $jobPosting->position_id);
            })
            ->take(3)
            ->get();

        return view('public.job-postings.show', compact('jobPosting', 'relatedJobs'));
    }

    public function apply(Request $request, JobPosting $jobPosting)
    {
        try {
            \Log::info('Iniciando proceso de aplicación para vacante: ' . $jobPosting->id);
            
            if ($jobPosting->status !== 'published' || !$jobPosting->is_active) {
                \Log::warning('Intento de aplicación a vacante no publicada o inactiva: ' . $jobPosting->id);
                abort(404);
            }

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'current_position' => 'nullable|string|max:255',
                'current_company' => 'nullable|string|max:255',
                'years_of_experience' => 'nullable|integer|min:0',
                'education_level' => 'nullable|string|max:255',
                'expected_salary' => 'nullable|numeric|min:0',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'cover_letter' => 'nullable|string',
                'source' => 'nullable|string|max:255',
            ]);

            \Log::info('Datos validados correctamente para: ' . $validated['email']);

            // Manejar la subida del CV
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $filename = Str::slug($validated['first_name'] . '-' . $validated['last_name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
                
                // Asegurarse de que el directorio existe
                $directory = 'resumes';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                
                $path = $file->storeAs($directory, $filename, 'public');
                $validated['resume_path'] = $path;
                \Log::info('CV guardado en: ' . $path);
            }

            // Establecer el estado inicial y la vacante
            $validated['status'] = 'pending';
            $validated['job_posting_id'] = $jobPosting->id;

            $candidate = Candidate::create($validated);
            \Log::info('Candidato creado exitosamente con ID: ' . $candidate->id);

            return redirect()->route('public.job-postings.show', $jobPosting)
                ->with('success', '¡Tu postulación ha sido enviada exitosamente! Te contactaremos pronto.');

        } catch (\Exception $e) {
            \Log::error('Error en el proceso de aplicación: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hubo un error al procesar tu aplicación. Por favor, intenta nuevamente.');
        }
    }
} 