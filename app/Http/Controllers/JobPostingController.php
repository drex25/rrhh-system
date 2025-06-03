<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobPostingController extends Controller
{
    public function index(Request $request)
    {
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

        if ($request->has('department') && $request->input('department') !== '') {
            $query->where('department_id', $request->input('department'));
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('employment_type', $request->input('type'));
        }

        $jobPostings = $query->paginate(10);
        $departments = Department::where('is_active', true)->get();

        return view('job-postings.index', compact('jobPostings', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        
        return view('job-postings.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'employment_type' => 'required|string',
            'work_schedule' => 'required|string',
            'location' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
            'vacancies' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        JobPosting::create($validated);

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
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        
        return view('job-postings.edit', compact('jobPosting', 'departments', 'positions'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'employment_type' => 'required|string',
            'work_schedule' => 'required|string',
            'location' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
            'vacancies' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $jobPosting->update($validated);

        return redirect()->route('job-postings.index')
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