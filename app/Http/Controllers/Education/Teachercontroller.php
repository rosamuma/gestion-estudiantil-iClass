<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::withCount('courses')
            ->when(request('search'), fn($q) => $q->where('name','like','%'.request('search').'%')->orWhere('specialty','like','%'.request('search').'%'))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->orderBy('name')->paginate(15)->withQueryString();
        return view('education.teachers.index', compact('teachers'));
    }

    public function create() { return view('education.teachers.form'); }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:teachers,email',
            'specialty' => 'nullable|string|max:255',
            'status'    => 'required|in:active,inactive',
        ]);
        Teacher::create($request->only('name','email','specialty','status'));
        return redirect()->route('education.teachers.index')->with('success', '✅ Docente registrado.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('courses');
        return view('education.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher) { return view('education.teachers.form', compact('teacher')); }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:teachers,email,'.$teacher->id,
            'specialty' => 'nullable|string|max:255',
            'status'    => 'required|in:active,inactive',
        ]);
        $teacher->update($request->only('name','email','specialty','status'));
        return redirect()->route('education.teachers.index')->with('success', '✅ Docente actualizado.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('education.teachers.index')->with('success', 'Docente eliminado.');
    }
}
