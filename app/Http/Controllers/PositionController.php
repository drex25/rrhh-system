<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::paginate(10);
        return view('positions.index', compact('positions'));
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
        return view('positions.edit', compact('position'));
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
