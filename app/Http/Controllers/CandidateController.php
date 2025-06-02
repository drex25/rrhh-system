<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Candidate::with('jobPosting');

        // Aplicar filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->job_posting_id);
        }

        $candidates = $query->latest()->paginate(10);
        $jobPostings = JobPosting::all();

        return view('candidates.index', compact('candidates', 'jobPostings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobPostings = JobPosting::all();
        return view('candidates.create', compact('jobPostings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'job_posting_id' => 'required|exists:job_postings,id',
            'current_position' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'education_level' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'nullable|string',
            'notes' => 'nullable|string',
            'source' => 'nullable|string|max:255',
        ]);

        // Manejar la subida del CV
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = Str::slug($validated['first_name'] . '-' . $validated['last_name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resumes', $filename, 'public');
            $validated['resume_path'] = $path;
        }

        // Establecer el estado inicial
        $validated['status'] = 'pending';

        $candidate = Candidate::create($validated);

        return redirect()->route('candidates.show', $candidate)
            ->with('success', 'Candidato creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        $jobPostings = JobPosting::all();
        return view('candidates.edit', compact('candidate', 'jobPostings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'job_posting_id' => 'required|exists:job_postings,id',
            'status' => 'required|string|in:pending,reviewing,interviewed,offered,hired,rejected',
            'current_position' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'education_level' => 'nullable|string|max:255',
            'expected_salary' => 'nullable|numeric|min:0',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'nullable|string',
            'notes' => 'nullable|string',
            'source' => 'nullable|string|max:255',
        ]);

        // Manejar la subida del CV
        if ($request->hasFile('resume')) {
            // Eliminar el CV anterior si existe
            if ($candidate->resume_path) {
                Storage::disk('public')->delete($candidate->resume_path);
            }

            $file = $request->file('resume');
            $filename = Str::slug($validated['first_name'] . '-' . $validated['last_name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resumes', $filename, 'public');
            $validated['resume_path'] = $path;
        }

        $candidate->update($validated);

        return redirect()->route('candidates.show', $candidate)
            ->with('success', 'Candidato actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        // Eliminar el CV si existe
        if ($candidate->resume_path) {
            Storage::disk('public')->delete($candidate->resume_path);
        }

        $candidate->delete();

        return redirect()->route('candidates.index')
            ->with('success', 'Candidato eliminado exitosamente.');
    }

    public function downloadResume(Candidate $candidate)
    {
        if (!$candidate->resume_path) {
            return back()->with('error', 'El candidato no tiene un CV adjunto.');
        }

        return Storage::disk('public')->download($candidate->resume_path);
    }
}
