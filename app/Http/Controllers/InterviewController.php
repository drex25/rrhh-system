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

class InterviewController extends Controller
{
    /**
     * Display a listing of the interviews.
     */
    public function index(Request $request)
    {
        $query = Interview::with(['candidate', 'jobPosting', 'interviewer']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('interviewer_id')) {
            $query->where('interviewer_id', $request->interviewer_id);
        }

        $interviews = $query->latest()->paginate(10);
        $interviewers = User::role('interviewer')->get();

        return view('interviews.index', compact('interviews', 'interviewers'));
    }

    /**
     * Show the form for creating a new interview.
     */
    public function create()
    {
        $candidates = Candidate::where('status', 'active')->get();
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
            'type' => 'required|in:phone,video,in_person',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'required_if:type,in_person',
            'meeting_link' => 'required_if:type,video|url',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $interview = Interview::create([
                'candidate_id' => $validated['candidate_id'],
                'job_posting_id' => $validated['job_posting_id'],
                'interviewer_id' => $validated['interviewer_id'],
                'type' => $validated['type'],
                'scheduled_at' => $validated['scheduled_at'],
                'location' => $validated['location'] ?? null,
                'meeting_link' => $validated['meeting_link'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'scheduled',
            ]);

            // Enviar email al candidato
            Mail::to($interview->candidate->email)
                ->send(new InterviewScheduled($interview));

            // Enviar email al entrevistador
            Mail::to($interview->interviewer->email)
                ->send(new InterviewScheduled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
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

        $candidates = Candidate::where('status', 'active')->get();
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
                ->with('error', 'No se puede editar una entrevista completada.');
        }

        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'job_posting_id' => 'required|exists:job_postings,id',
            'interviewer_id' => 'required|exists:users,id',
            'type' => 'required|in:phone,video,in_person',
            'scheduled_at' => 'required|date|after:now',
            'location' => 'required_if:type,in_person',
            'meeting_link' => 'required_if:type,video|url',
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

            // Enviar email de reprogramación
            Mail::to($interview->candidate->email)
                ->send(new InterviewRescheduled($interview));

            Mail::to($interview->interviewer->email)
                ->send(new InterviewRescheduled($interview));

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

            // Enviar email de cancelación
            Mail::to($interview->candidate->email)
                ->send(new InterviewCancelled($interview));

            Mail::to($interview->interviewer->email)
                ->send(new InterviewCancelled($interview));

            $interview->delete();

            DB::commit();

            return redirect()
                ->route('interviews.index')
                ->with('success', 'Entrevista eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al eliminar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Mark the interview as completed.
     */
    public function complete(Request $request, Interview $interview)
    {
        if ($interview->status === 'completed') {
            return back()->with('error', 'La entrevista ya está completada.');
        }

        $validated = $request->validate([
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'recommendation' => 'required|in:hire,maybe,reject',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'status' => 'completed',
                'feedback' => $validated['feedback'],
                'rating' => $validated['rating'],
                'recommendation' => $validated['recommendation'],
                'completed_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista marcada como completada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al completar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Cancel the interview.
     */
    public function cancel(Request $request, Interview $interview)
    {
        if ($interview->status === 'completed') {
            return back()->with('error', 'No se puede cancelar una entrevista completada.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'status' => 'cancelled',
                'cancellation_reason' => $validated['cancellation_reason'],
                'cancelled_at' => now(),
            ]);

            // Enviar email de cancelación
            Mail::to($interview->candidate->email)
                ->send(new InterviewCancelled($interview));

            Mail::to($interview->interviewer->email)
                ->send(new InterviewCancelled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista cancelada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al cancelar la entrevista: ' . $e->getMessage());
        }
    }

    /**
     * Reschedule the interview.
     */
    public function reschedule(Request $request, Interview $interview)
    {
        if ($interview->status === 'completed') {
            return back()->with('error', 'No se puede reprogramar una entrevista completada.');
        }

        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'reschedule_reason' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $interview->update([
                'scheduled_at' => $validated['scheduled_at'],
                'reschedule_reason' => $validated['reschedule_reason'],
            ]);

            // Enviar email de reprogramación
            Mail::to($interview->candidate->email)
                ->send(new InterviewRescheduled($interview));

            Mail::to($interview->interviewer->email)
                ->send(new InterviewRescheduled($interview));

            DB::commit();

            return redirect()
                ->route('interviews.show', $interview)
                ->with('success', 'Entrevista reprogramada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al reprogramar la entrevista: ' . $e->getMessage());
        }
    }
} 