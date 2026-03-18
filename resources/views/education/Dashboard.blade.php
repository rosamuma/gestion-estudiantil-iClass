<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        {{-- Banner de bienvenida --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 p-4" style="background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%);border-radius:16px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="text-white font-weight-bold mb-1">Hola, {{ auth()->user()->name }} 👋</h4>
                            <p class="text-white mb-0" style="opacity:.7;font-size:13px;">
                                <span class="badge me-2 px-2 py-1"
                                    style="background:{{ auth()->user()->isAdmin() ? '#ef4444' : (auth()->user()->isTeacher() ? '#f59e0b' : '#10b981') }};font-size:10px;border-radius:6px;">
                                    {{ auth()->user()->role_label }}
                                </span>
                                {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                            </p>
                        </div>
                        @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                        <div class="d-flex gap-2">
                            <a href="{{ route('education.students.create') }}" class="btn btn-sm btn-white mb-0">
                                <i class="fas fa-user-plus me-1"></i> Nuevo Estudiante
                            </a>
                            <a href="{{ route('education.attendance.create') }}" class="btn btn-sm mb-0"
                                style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.25);">
                                <i class="fas fa-clipboard-check me-1"></i> Registrar Asistencia
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats cards --}}
        <div class="row mb-4">
            @php
            $statCards = [
                ['icon'=>'fas fa-user-graduate','label'=>'Total Estudiantes','value'=>$totalStudents,'color'=>'#3b82f6','link'=>route('education.students.index'),'linkText'=>'Ver todos'],
                ['icon'=>'fas fa-book-open','label'=>'Cursos Activos','value'=>$activeCourses,'color'=>'#10b981','link'=>route('education.courses.index'),'linkText'=>'Ver cursos'],
                ['icon'=>'fas fa-chalkboard-teacher','label'=>'Docentes','value'=>$totalTeachers,'color'=>'#8b5cf6','link'=>auth()->user()->isAdmin() ? route('education.teachers.index') : '#','linkText'=>'Ver docentes'],
                ['icon'=>'fas fa-chart-line','label'=>'Promedio General','value'=>$avgGrade.'/10','color'=>'#f59e0b','link'=>route('education.grades.index'),'linkText'=>'Ver notas'],
            ];
            @endphp
            @foreach($statCards as $card)
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-xs h-100" style="border-radius:14px;border-left:3px solid {{ $card['color'] }} !important;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <p class="text-sm text-secondary mb-1">{{ $card['label'] }}</p>
                                <h3 class="font-weight-bold mb-0">{{ $card['value'] }}</h3>
                            </div>
                            <div class="d-flex align-items-center justify-content-center border-radius-md"
                                style="width:42px;height:42px;background:{{ $card['color'] }}18;">
                                <i class="{{ $card['icon'] }}" style="color:{{ $card['color'] }};font-size:16px;"></i>
                            </div>
                        </div>
                        <a href="{{ $card['link'] }}" class="text-xs mt-2 d-block font-weight-bold" style="color:{{ $card['color'] }};">
                            {{ $card['linkText'] }} <i class="fas fa-arrow-right ms-1" style="font-size:9px;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Gráficos --}}
        <div class="row mb-4">
            {{-- Promedios por curso --}}
            <div class="col-lg-7 mb-3">
                <div class="card border-0 shadow-xs h-100" style="border-radius:14px;">
                    <div class="card-header pb-0 pt-3 px-4 border-0">
                        <h6 class="font-weight-bold mb-0">Promedio por Curso</h6>
                        <p class="text-xs text-secondary mb-0">Rendimiento académico actual</p>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <canvas id="chart-grades" height="180"></canvas>
                    </div>
                </div>
            </div>
            {{-- Asistencia últimos 7 días --}}
            <div class="col-lg-5 mb-3">
                <div class="card border-0 shadow-xs h-100" style="border-radius:14px;">
                    <div class="card-header pb-0 pt-3 px-4 border-0">
                        <h6 class="font-weight-bold mb-0">Asistencia — últimos 7 días</h6>
                        <p class="text-xs text-secondary mb-0">Presentes vs Ausentes</p>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <canvas id="chart-attendance" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabla de estudiantes recientes --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-xs" style="border-radius:14px;">
                    <div class="card-header pb-0 pt-3 px-4 border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="font-weight-bold mb-0">Estudiantes Recientes</h6>
                                <p class="text-xs text-secondary mb-0">Últimos inscritos en la plataforma</p>
                            </div>
                            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                            <div class="d-flex gap-2">
                                <a href="{{ route('education.students.create') }}" class="btn btn-sm btn-dark mb-0">
                                    <i class="fas fa-plus me-1"></i>Nuevo
                                </a>
                                <a href="{{ route('education.students.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                                    Ver todos
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="table-responsive px-2">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Estudiante</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Semestre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentStudents as $s)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width:36px;height:36px;background:#1e293b;border-radius:10px;font-size:12px;">
                                                    {{ strtoupper(substr($s->name,0,2)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $s->name }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ $s->student_code ?? $s->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><p class="text-sm mb-0">{{ $s->program->name ?? '—' }}</p></td>
                                        <td class="text-center"><span class="badge bg-light text-dark">{{ $s->semester }}°</span></td>
                                        <td class="text-center">
                                            @php $sc=['active'=>['success','Activo'],'inactive'=>['secondary','Inactivo'],'graduated'=>['info','Graduado']][$s->status]??['secondary',$s->status]; @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $sc[0] }}">{{ $sc[1] }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($s->average !== null)
                                                <span class="font-weight-bold {{ $s->average >= 6 ? 'text-success' : 'text-danger' }}">{{ $s->average }}</span>
                                            @else
                                                <span class="text-secondary text-xs">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-secondary">No hay estudiantes aún. <a href="{{ route('education.students.create') }}">Crear el primero</a></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-app.footer />
</main>

@push('scripts')
<script>
// Chart promedios por curso
const ctxG = document.getElementById('chart-grades');
if (ctxG) {
    const chartData = @json($chartCourses);
    new Chart(ctxG, {
        type: 'bar',
        data: {
            labels: chartData.map(c => c.name),
            datasets: [{
                label: 'Promedio',
                data: chartData.map(c => c.average),
                backgroundColor: chartData.map(c => c.average >= 7 ? 'rgba(16,185,129,0.75)' : c.average >= 5 ? 'rgba(245,158,11,0.75)' : 'rgba(239,68,68,0.75)'),
                borderRadius: 8, borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { min: 0, max: 10, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
}
// Chart asistencia
const ctxA = document.getElementById('chart-attendance');
if (ctxA) {
    const attData = @json($attendanceStats);
    new Chart(ctxA, {
        type: 'line',
        data: {
            labels: attData.map(d => d.date),
            datasets: [
                { label: 'Presentes', data: attData.map(d => d.present), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, pointRadius: 4 },
                { label: 'Ausentes',  data: attData.map(d => d.absent),  borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)',  fill: true, tension: 0.4, pointRadius: 4 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12 } } },
            scales: {
                y: { min: 0, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
}
</script>
@endpush
</x-app-layout>
