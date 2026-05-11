<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Attendance;
use App\Models\Education\Course;
use App\Models\Education\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $query = Attendance::with(['student','course'])
            ->when(request('course_id'), fn($q) => $q->where('course_id', request('course_id')))
            ->when(request('date_from') && request('date_to'), function ($q) {
                $q->whereBetween('date', [request('date_from'), request('date_to')]);
            })
            ->when(request('status'), fn($q) => $q->where('status', request('status')));

        $attendances = (clone $query)
            ->orderByDesc('date')
            ->orderBy('student_id')
            ->paginate(20)
            ->withQueryString();

        $presentToday = (clone $query)->where('status','present')->count();
        $absentToday  = (clone $query)->where('status','absent')->count();
        $justToday    = (clone $query)->where('status','justified')->count();

        $total = $presentToday + $absentToday + $justToday;

        $avgPct = $total > 0 
            ? round(($presentToday + $justToday) / $total * 100) 
            : 0;

        $courses = Course::where('status','active')->orderBy('name')->get();

        return view('education.attendance.index', compact(
            'attendances',
            'courses',
            'presentToday',
            'absentToday',
            'justToday',
            'avgPct'
        ));
    }

    public function create()
    {
        return view('education.attendance.form', [
            'courses'  => Course::where('status','active')->orderBy('name')->get(),
            'students' => Student::where('status','active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'date'       => 'required|date',
            'status'     => 'required|in:present,absent,justified',
            'notes'      => 'nullable|string|max:500',
        ], 
        [
            'status.required' => 'El estado es obligatorio.',
            'status.in'       => 'El estado seleccionado no es válido.',
        ]);
        Attendance::updateOrCreate(
            ['student_id'=>$data['student_id'],'course_id'=>$data['course_id'],'date'=>$data['date']],
            $data
        );
        return redirect()->route('education.attendance.index')->with('success', '✅ Asistencia registrada.');
    }

    public function edit(Attendance $attendance)
    {
        $attendance->load(['student', 'course']);
        return view('education.attendance.form', [
            'attendance' => $attendance,
            'courses'    => Course::where('status','active')->orderBy('name')->get(),
            'students'   => Student::where('status','active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'status' => 'required|in:present,absent,justified',
            'notes'  => 'nullable|string|max:500',
        ]);
        $attendance->update($data);
        return redirect()->route('education.attendance.index')->with('success', '✅ Asistencia actualizada.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('education.attendance.index')->with('success', 'Registro eliminado.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate(['course_id'=>'required|exists:courses,id','date'=>'required|date','records'=>'required|array']);
        foreach ($request->records as $r) {
            Attendance::updateOrCreate(
                ['student_id'=>$r['student_id'],'course_id'=>$request->course_id,'date'=>$request->date],
                ['status'=>$r['status'],'notes'=>$r['notes']??null]
            );
        }
        return redirect()->route('education.attendance.index')->with('success', '✅ Lista de asistencia guardada.');
    }
}
