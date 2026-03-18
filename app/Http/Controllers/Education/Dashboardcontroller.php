<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Course;
use App\Models\Education\Grade;
use App\Models\Education\Student;
use App\Models\Education\Teacher;
use App\Models\Education\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents  = Student::count();
        $activeCourses  = Course::where('status', 'active')->count();
        $totalTeachers  = Teacher::count();
        $avgGrade       = round((float)(Grade::whereNotNull('average')->avg('average') ?? 0), 1);
        $recentStudents = Student::with('program')->latest()->take(8)->get();

        // Datos para gráfico: promedio por curso (top 6)
        $chartCourses = Course::with(['grades' => fn($q) => $q->whereNotNull('average')])
            ->where('status', 'active')->take(6)->get()
            ->map(fn($c) => [
                'name'    => $c->code ?? substr($c->name, 0, 12),
                'average' => round((float)($c->grades->avg('average') ?? 0), 1),
            ]);

        // Asistencia últimos 7 días
        $attendanceStats = collect(range(6, 0))->map(function ($d) {
            $date    = now()->subDays($d)->format('Y-m-d');
            $present = Attendance::whereDate('date', $date)->where('status', 'present')->count();
            $absent  = Attendance::whereDate('date', $date)->where('status', 'absent')->count();
            return ['date' => now()->subDays($d)->format('d/m'), 'present' => $present, 'absent' => $absent];
        });

        return view('education.dashboard', compact(
            'totalStudents', 'activeCourses', 'totalTeachers', 'avgGrade',
            'recentStudents', 'chartCourses', 'attendanceStats'
        ));
    }
}
