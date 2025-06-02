<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Position::query();

        // Filtro de búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Filtro por departamento
        if ($request->has('department') && $request->input('department') !== '') {
            $query->where('department_id', $request->input('department'));
        }

        // Filtro por estado
        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('is_active', $request->input('status'));
        }

        $positions = $query->paginate(10);
        $departments = Department::where('is_active', true)->get();

        return view('positions.index', compact('positions', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = \App\Models\Department::where('is_active', true)->get();
        return view('positions.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:positions,code',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'min_salary' => 'nullable|string',
            'max_salary' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Formatear salarios (acepta punto o coma como decimal)
        $validated['min_salary'] = isset($validated['min_salary']) ? str_replace([',', ' '], ['.', ''], $validated['min_salary']) : null;
        $validated['max_salary'] = isset($validated['max_salary']) ? str_replace([',', ' '], ['.', ''], $validated['max_salary']) : null;

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Posición creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        $departments = Department::where('is_active', true)->get();
        return view('positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:positions,code,' . $position->id,
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'min_salary' => 'nullable|string',
            'max_salary' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['min_salary'] = isset($validated['min_salary']) ? str_replace([',', ' '], ['.', ''], $validated['min_salary']) : null;
        $validated['max_salary'] = isset($validated['max_salary']) ? str_replace([',', ' '], ['.', ''], $validated['max_salary']) : null;

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Posición actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Posición eliminada exitosamente.');
    }
}
