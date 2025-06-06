<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'status' => 'required|string|in:pending,reviewing,shortlisted,interview_scheduled,interviewed,technical_test,reference_check,offered,accepted,hired,rejected,withdrawn',
            'rejection_reason' => 'nullable|required_if:status,rejected|string|max:255',
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

        // Actualizar el estado y manejar la lógica de transición
        $oldStatus = $candidate->status;
        $newStatus = $validated['status'];

        // Si el estado cambió a rechazado, asegurarse de que haya una razón
        if ($newStatus === 'rejected' && empty($validated['rejection_reason'])) {
            return back()->with('error', 'Debe proporcionar una razón para el rechazo.');
        }

        // Si el estado cambió a contratado, verificar que haya pasado por todos los estados necesarios
        if ($newStatus === 'hired' && !in_array($oldStatus, ['accepted'])) {
            return back()->with('error', 'El candidato debe haber aceptado la oferta antes de ser contratado.');
        }

        $candidate->update($validated);

        // Notificar al candidato sobre el cambio de estado
        if ($oldStatus !== $newStatus) {
            // Aquí iría la lógica para enviar notificaciones por email
            // TODO: Implementar notificaciones por email
        }

        return redirect()->route('candidates.show', $candidate)
            ->with('success', 'Candidato actualizado exitosamente.');
    }

    /**
     * Actualiza el estado del candidato.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Candidate $candidate)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in([
                'pending',
                'reviewing',
                'shortlisted',
                'interview_scheduled',
                'interviewed',
                'technical_test',
                'reference_check',
                'offered',
                'accepted',
                'hired',
                'rejected',
                'withdrawn'
            ])],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:1000'],
        ]);

        // Verificar si se requiere una razón para el rechazo
        if ($request->status === 'rejected' && empty($request->rejection_reason)) {
            return back()->withErrors(['rejection_reason' => 'La razón del rechazo es requerida.']);
        }

        // Actualizar el estado y la razón de rechazo si corresponde
        $candidate->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        // Notificar al candidato sobre el cambio de estado
        // TODO: Implementar notificación por email

        return redirect()->route('candidates.show', $candidate)
            ->with('success', 'Estado del candidato actualizado correctamente.');
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
