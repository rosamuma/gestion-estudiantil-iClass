<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Course;
use App\Models\Education\Grade;
use App\Models\Education\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student','course'])
            ->when(request('course_id'), fn($q) => $q->where('course_id', request('course_id')))
            ->when(request('period'),    fn($q) => $q->where('period', request('period')))
            ->when(request('status') === 'approved', fn($q) => $q->where('average','>=',6))
            ->when(request('status') === 'failed',   fn($q) => $q->where('average','<',6)->whereNotNull('average'))
            ->when(request('status') === 'pending',  fn($q) => $q->whereNull('average'))
            ->orderByDesc('updated_at')->paginate(20)->withQueryString();

        $courses = Course::orderBy('name')->get();
        $periods = Grade::distinct()->orderByDesc('period')->pluck('period');
        return view('education.grades.index', compact('grades','courses','periods'));
    }

    public function create()
    {
        return view('education.grades.form', [
            'courses'  => Course::orderBy('name')->get(),
            'students' => Student::where('status','active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'period'     => 'required|string|max:20',
            'grade_1'    => 'nullable|numeric|min:0|max:10',
            'grade_2'    => 'nullable|numeric|min:0|max:10',
            'grade_3'    => 'nullable|numeric|min:0|max:10',
            'notes'      => 'nullable|string|max:500',
        ]);
        $data['average'] = $this->calcAverage($data);
        Grade::create($data);
        return redirect()->route('education.grades.index')->with('success', '✅ Calificación registrada.');
    }

    public function edit(Grade $grade)
    {
        return view('education.grades.form', [
            'grade'    => $grade,
            'courses'  => Course::orderBy('name')->get(),
            'students' => Student::where('status','active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'grade_1' => 'nullable|numeric|min:0|max:10',
            'grade_2' => 'nullable|numeric|min:0|max:10',
            'grade_3' => 'nullable|numeric|min:0|max:10',
            'notes'   => 'nullable|string|max:500',
        ]);
        $data['average'] = $this->calcAverage($data);
        $grade->update($data);
        return redirect()->route('education.grades.index')->with('success', '✅ Calificación actualizada.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('education.grades.index')->with('success', 'Registro eliminado.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate(['course_id'=>'required|exists:courses,id','period'=>'required|string','grades'=>'required|array']);
        foreach ($request->grades as $g) {
            $avg = $this->calcAverage($g);
            Grade::updateOrCreate(
                ['student_id'=>$g['student_id'],'course_id'=>$request->course_id,'period'=>$request->period],
                array_merge($g, ['average'=>$avg])
            );
        }
        return redirect()->route('education.grades.index')->with('success', '✅ Calificaciones guardadas en bloque.');
    }

    private function calcAverage(array $data): ?float
    {
        $vals = array_filter([$data['grade_1']??null,$data['grade_2']??null,$data['grade_3']??null], fn($v)=>$v!==null&&$v!=='');
        return count($vals) ? round(array_sum($vals)/count($vals), 2) : null;
    }
}
