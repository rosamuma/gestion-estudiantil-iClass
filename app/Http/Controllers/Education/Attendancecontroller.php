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
        $attendances = Attendance::with(['student','course'])
            ->when(request('course_id'), fn($q) => $q->where('course_id', request('course_id')))
            ->when(request('date'),      fn($q) => $q->where('date', request('date')))
            ->when(request('status'),    fn($q) => $q->where('status', request('status')))
            ->orderByDesc('date')->orderBy('student_id')
            ->paginate(20)->withQueryString();

        $courses      = Course::where('status','active')->orderBy('name')->get();
        $presentToday = Attendance::whereDate('date', today())->where('status','present')->count();
        $absentToday  = Attendance::whereDate('date', today())->where('status','absent')->count();
        $justToday    = Attendance::whereDate('date', today())->where('status','justified')->count();
        $totalToday   = $presentToday + $absentToday + $justToday;
        $avgPct       = $totalToday > 0 ? round(($presentToday + $justToday) / $totalToday * 100) : 0;

        return view('education.attendance.index', compact('attendances','courses','presentToday','absentToday','justToday','avgPct'));
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
        ]);
        Attendance::updateOrCreate(
            ['student_id'=>$data['student_id'],'course_id'=>$data['course_id'],'date'=>$data['date']],
            $data
        );
        return redirect()->route('education.attendance.index')->with('success', '✅ Asistencia registrada.');
    }

    public function edit(Attendance $attendance)
    {
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
