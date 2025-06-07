<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class JobPostingController extends Controller
{
    public function index(Request $request)
    {
        Log::info('JobPostingController@index filtros recibidos', $request->all());
        $query = JobPosting::query()
            ->with(['department', 'position'])
            ->latest();

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

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type')) {
            $query->where('employment_type', $request->input('type'));
        }

        Log::info('JobPostingController@index SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        $jobPostings = $query->paginate(10);
        $departments = Department::where('is_active', true)->get();

        return view('job-postings.index', compact('jobPostings', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        $users = User::where('is_active', true)->get();
        return view('job-postings.create', compact('departments', 'positions', 'users'));
    }

    public function store(Request $request)
    {
        \Log::info('Request recibido en store', $request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'employment_type' => 'required|string',
            'work_schedule' => 'required|string',
            'modality' => 'required|in:remoto,hibrido,presencial',
            'location' => 'required|string',
            'min_salary' => 'nullable|numeric',
            'max_salary' => 'nullable|numeric',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
            'vacancies' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'interviewers' => 'nullable|array',
            'interviewers.*' => 'exists:users,id',
        ]);

        // Map form fields to database columns
        $data = [
            'title' => $validated['title'],
            'description' => $request->input('description'),
            'requirements' => $request->input('requirements'),
            'responsibilities' => $request->input('responsibilities'),
            'benefits' => $request->input('benefits'),
            'department_id' => $validated['department_id'],
            'position_id' => $validated['position_id'],
            'employment_type' => $validated['employment_type'],
            'work_schedule' => $validated['work_schedule'],
            'modality' => $validated['modality'],
            'location' => $validated['location'],
            'min_salary' => $request->input('salary_min'),
            'max_salary' => $request->input('salary_max'),
            'status' => $validated['status'],
            'closing_date' => $validated['closing_date'],
            'application_deadline' => $validated['closing_date'],
            'vacancies' => $validated['vacancies'],
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
        ];

        $jobPosting = JobPosting::create($data);
        \Log::info('Vacante creada:', ['jobPosting' => $jobPosting]);

        if ($request->filled('interviewers')) {
            \Log::info('Sincronizando entrevistadores en store', ['ids' => $request->input('interviewers')]);
            $jobPosting->interviewers()->sync($request->input('interviewers'));
        }

        return redirect()->route('job-postings.index')
            ->with('success', 'Vacante creada exitosamente.');
    }

    public function show(JobPosting $jobPosting)
    {
        $jobPosting->load(['department', 'position', 'candidates']);
        return view('job-postings.show', compact('jobPosting'));
    }

    public function edit(JobPosting $jobPosting)
    {
        $jobPosting->load('interviewers');
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        $users = User::where('is_active', true)->get();
        return view('job-postings.edit', compact('jobPosting', 'departments', 'positions', 'users'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        \Log::info('Request recibido en update', $request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'employment_type' => 'required|string',
            'work_schedule' => 'required|string',
            'modality' => 'required|in:remoto,hibrido,presencial',
            'location' => 'required|string',
            'min_salary' => 'nullable|numeric',
            'max_salary' => 'nullable|numeric',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
            'vacancies' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'interviewers' => 'nullable|array',
            'interviewers.*' => 'exists:users,id',
        ]);

        // Map form fields to database columns
        $data = [
            'title' => $validated['title'],
            'description' => $request->input('description'),
            'requirements' => $request->input('requirements'),
            'responsibilities' => $request->input('responsibilities'),
            'benefits' => $request->input('benefits'),
            'department_id' => $validated['department_id'],
            'position_id' => $validated['position_id'],
            'employment_type' => $validated['employment_type'],
            'work_schedule' => $validated['work_schedule'],
            'modality' => $validated['modality'],
            'location' => $validated['location'],
            'min_salary' => $request->input('salary_min'),
            'max_salary' => $request->input('salary_max'),
            'status' => $validated['status'],
            'closing_date' => $validated['closing_date'],
            'application_deadline' => $validated['closing_date'],
            'vacancies' => $validated['vacancies'],
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
        ];

        // Slug único ignorando el registro actual
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (
            JobPosting::where('slug', $slug)
                ->where('id', '!=', $jobPosting->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        $jobPosting->update($data);

        if ($request->filled('interviewers')) {
            \Log::info('Sincronizando entrevistadores en update', ['ids' => $request->input('interviewers')]);
            $jobPosting->interviewers()->sync($request->input('interviewers'));
        } else {
            \Log::info('Sincronizando entrevistadores en update: vacío');
            $jobPosting->interviewers()->sync([]);
        }

        return redirect()->route('job-postings.show', $jobPosting)
            ->with('success', 'Vacante actualizada exitosamente.');
    }

    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();

        return redirect()->route('job-postings.index')
            ->with('success', 'Vacante eliminada exitosamente.');
    }

    public function toggleStatus(JobPosting $jobPosting)
    {
        $jobPosting->update([
            'is_active' => !$jobPosting->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Estado de la vacante actualizado exitosamente.');
    }

    public function toggleFeatured(JobPosting $jobPosting)
    {
        $jobPosting->update([
            'is_featured' => !$jobPosting->is_featured
        ]);

        return redirect()->back()
            ->with('success', 'Estado destacado actualizado exitosamente.');
    }
} 

//migrar a la nueva base 