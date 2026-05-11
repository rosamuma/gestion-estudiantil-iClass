<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount(['students','courses'])
            ->when(request('search'), fn($q) => $q->where('name','like','%'.request('search').'%')->orWhere('code','like','%'.request('search').'%'))
            ->orderBy('name')->paginate(15)->withQueryString();
        return view('education.programs.index', compact('programs'));
    }

    public function create() { return view('education.programs.form'); }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'code'               => 'nullable|string|max:20|unique:programs,code',
            'description'        => 'nullable|string|max:1000',
            'duration_semesters' => 'required|integer|min:1|max:16',
        ]);
        Program::create($request->only('name','code','description','duration_semesters'));
        return redirect()->route('education.programs.index')->with('success', '✅ Programa creado.');
    }

    public function show(Program $program)
    {
        $program->load(['students','courses']);
        return view('education.programs.show', compact('program'));
    }

    public function edit(Program $program) { return view('education.programs.form', compact('program')); }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'code'               => 'nullable|string|max:20|unique:programs,code,'.$program->id,
            'description'        => 'nullable|string|max:1000',
            'duration_semesters' => 'required|integer|min:1|max:16',
        ]);
        $program->update($request->only('name','code','description','duration_semesters'));
        return redirect()->route('education.programs.index')->with('success', '✅ Programa actualizado.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('education.programs.index')->with('success', 'Programa eliminado.');
    }
}
