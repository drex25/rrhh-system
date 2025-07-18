<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Candidate;
use App\Models\JobPosting;
use App\Models\User;
use App\Mail\InterviewScheduled;
use App\Mail\InterviewCancelled;
use App\Mail\InterviewRescheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class InterviewController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the interviews.
     */
    public function index(Request $request)
    {
        $query = Interview::with(['candidate', 'jobPosting', 'interviewer']);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('interviewer_id')) {
            $query->where('interviewer_id', $request->interviewer_id);
        }

        // Si el usuario es un entrevistador, solo mostrar sus entrevistas
        if (Auth::user()->hasRole('interviewer')) {
            $query->where('interviewer_id', Auth::id());
        }

        $interviews = $query->latest('scheduled_at')->paginate(10);
        $interviewers = User::role('interviewer')->get();

        return view('interviews.index', compact('interviews', 'interviewers'));
    }

    /**
     * Show the form for creating a new interview.
     */
    public function create()
    {
        $candidates = Candidate::where('status', '!=', 'rejected')->get();
        $jobPostings = JobPosting::where('status', 'published')->get();
        $interviewers = User::role('interviewer')->get();

        return view('interviews.create', compact('candidates', 'jobPostings', 'interviewers'));
    }

    /**
     * Store a newly created interview in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'job_posting_id' => 'required|exists:job_postings,id',
            'interviewer_id' => 'required|exists:users,id',
            'type' => 'required|in:phone,video,in-person',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'required_if:type,in-person',
            'meeting_link' => 'required_if:type,video',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $interview = Interview::create([
                'candidate_id' => $validated['candidate_id'],
                'job_posting_id' => $validated['job_posting_id'],
                'interviewer_id' => $validated['interviewer_id'],
                'type' => $validated['type'],
                'status' => 'scheduled',
                'scheduled_at' => $validated['scheduled_at'],
                'location' => $validated['location'] ?? null,
                'meeting_link' => $validated['meeting_link'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Actualizar el estado del candidato a 'interview_scheduled'
            $candidate = Candidate::find($validated['candidate_id']);
            $candidate->update(['status' => 'interview_scheduled']);

            // Enviar correo al candidato
            Mail::to($interview->candidate->email)->send(new InterviewScheduled($interview));

            // Enviar correo al entrevistador
            Mail::to($interview->interviewer->email)->send(new InterviewScheduled($interview));

            DB::commit();

            return redirect()
                ->route('candidates.show', $candidate)
                ->with('success', 'Entrevista programada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al programar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified interview.
     */
    public function show(Interview $interview)
    {
        $interview->load(['candidate', 'jobPosting', 'interviewer']);
        return view('interviews.show', compact('interview'));
    }

    /**
     * Show the form for editing the specified interview.
     */
    public function edit(Interview $interview)
    {
        if ($interview->status === 'completed') {
            return redirect()
                ->route('interviews.show', $interview)
                ->with('error', 'No se puede editar una entrevista completada.');
        }

        $candidates = Candidate::where('status', '!=', 'rejected')->get();
        $jobPostings = JobPosting::where('status', 'published')->get();
        $interviewers = User::role('interviewer')->get();

        return view('interviews.edit', compact('interview', 'candidates', 'jobPostings', 'interviewers'));
    }

    /**
     * Update the specified interview in storage.
     */
    public function update(Request $request, Interview $interview)
    {
        if ($interview->status === 'completed') {
            return redirect()
                ->route('interviews.show', $interview)
                ->with('error', 'No se puede modificar una entrevista completada.');
        }

        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'job_posting_id' => 'required|exists:job_postings,id',
            'interviewer_id' => 'required|exists:users,id',
            'type' => 'required|in:phone,video,in-person',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'required_if:type,in-person',
            'meeting_link' => 'required_if:type,video',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'candidate_id' => $validated['candidate_id'],
                'job_posting_id' => $validated['job_posting_id'],
                'interviewer_id' => $validated['interviewer_id'],
                'type' => $validated['type'],
                'scheduled_at' => $validated['scheduled_at'],
                'location' => $validated['location'] ?? null,
                'meeting_link' => $validated['meeting_link'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Enviar correo de reprogramación
            Mail::to($interview->candidate->email)->send(new InterviewRescheduled($interview));
            Mail::to($interview->interviewer->email)->send(new InterviewRescheduled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified interview from storage.
     */
    public function destroy(Interview $interview)
    {
        if ($interview->status === 'completed') {
            return redirect()
                ->route('interviews.show', $interview)
                ->with('error', 'No se puede eliminar una entrevista completada.');
        }

        try {
            DB::beginTransaction();

            // Enviar correo de cancelación
            Mail::to($interview->candidate->email)->send(new InterviewCancelled($interview));
            Mail::to($interview->interviewer->email)->send(new InterviewCancelled($interview));

            $interview->delete();

            DB::commit();

            return redirect()
                ->route('interviews.index')
                ->with('success', 'Entrevista eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Mark an interview as completed.
     */
    public function complete(Request $request, Interview $interview)
    {
        if ($interview->status !== 'scheduled') {
            return back()->with('error', 'Solo se pueden completar entrevistas programadas.');
        }

        $validated = $request->validate([
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'status' => 'completed',
                'completed_at' => now(),
                'feedback' => $validated['feedback'],
                'rating' => $validated['rating'],
            ]);

            // Actualizar el estado del candidato a 'interviewed'
            $interview->candidate->update(['status' => 'interviewed']);

            DB::commit();

            return redirect()
                ->route('candidates.show', $interview->candidate)
                ->with('success', 'Entrevista marcada como completada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al completar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Cancel an interview.
     */
    public function cancel(Request $request, Interview $interview)
    {
        if ($interview->status !== 'scheduled') {
            return back()->with('error', 'Solo se pueden cancelar entrevistas programadas.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'notes' => $interview->notes . "\n\nRazón de cancelación: " . $validated['cancellation_reason'],
            ]);

            // Enviar correo de cancelación
            Mail::to($interview->candidate->email)->send(new InterviewCancelled($interview));
            Mail::to($interview->interviewer->email)->send(new InterviewCancelled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista cancelada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al cancelar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Reschedule an interview.
     */
    public function reschedule(Request $request, Interview $interview)
    {
        if ($interview->status !== 'scheduled') {
            return back()->with('error', 'Solo se pueden reprogramar entrevistas programadas.');
        }

        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'reschedule_reason' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'scheduled_at' => $validated['scheduled_at'],
                'notes' => $interview->notes . "\n\nRazón de reprogramación: " . $validated['reschedule_reason'],
            ]);

            // Enviar correo de reprogramación
            Mail::to($interview->candidate->email)->send(new InterviewRescheduled($interview));
            Mail::to($interview->interviewer->email)->send(new InterviewRescheduled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista reprogramada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al reprogramar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new interview from candidate view.
     */
    public function createFromCandidate(Candidate $candidate)
    {
        $jobPostings = JobPosting::where('status', 'published')->get();
        $interviewers = User::role('interviewer')->get();

        return view('interviews.create', compact('candidate', 'jobPostings', 'interviewers'));
    }
} 