<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Asistencia</h4>
                <p class="text-secondary text-sm mb-0">Control de asistencia por curso</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('education.attendance.create') }}" class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i> Registrar
                </a>
            </div>
        </div>

        {{-- Stats de hoy --}}
        <div class="row mb-4">
            @foreach([['fas fa-check-circle','Presentes hoy',$presentToday,'#10b981'],['fas fa-times-circle','Ausentes hoy',$absentToday,'#ef4444'],['fas fa-info-circle','Justificados hoy',$justToday,'#6366f1'],['fas fa-percent','Asistencia %',$avgPct.'%','#f59e0b']] as [$ic,$lbl,$val,$clr])
            <div class="col-6 col-md-3 mb-2">
                <div class="card border-0 shadow-xs p-3 text-center" style="border-radius:12px;border-top:3px solid {{ $clr }} !important;">
                    <i class="{{ $ic }} mb-1" style="color:{{ $clr }};font-size:20px;"></i>
                    <h4 class="font-weight-bold mb-0" style="color:{{ $clr }};">{{ $val }}</h4>
                    <p class="text-xs text-secondary mb-0">{{ $lbl }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs" style="border-radius:12px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="card border-0 shadow-xs mb-4" style="border-radius:14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-xs text-secondary mb-1">Curso</label>
                        <select name="course_id" class="form-control form-control-sm">
                            <option value="">Todos</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-xs text-secondary mb-1">Fecha</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-xs text-secondary mb-1">Estado</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos</option>
                            <option value="present"   {{ request('status')==='present'   ?'selected':'' }}>Presente</option>
                            <option value="absent"    {{ request('status')==='absent'    ?'selected':'' }}>Ausente</option>
                            <option value="justified" {{ request('status')==='justified' ?'selected':'' }}>Justificado</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-dark btn-sm w-100">Filtrar</button></div>
                    <div class="col-md-2"><a href="{{ route('education.attendance.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a></div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-xs" style="border-radius:14px;overflow:hidden;">
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Estudiante</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Curso</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Fecha</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Notas</th>
                                <th class="pe-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $a)
                            @php $as=['present'=>['success','✅ Presente'],'absent'=>['danger','❌ Ausente'],'justified'=>['info','📋 Justificado']][$a->status]??['secondary',$a->status]; @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:32px;height:32px;background:#1e293b;border-radius:8px;font-size:11px;">
                                            {{ strtoupper(substr($a->student->name ?? '??', 0, 2)) }}
                                        </div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $a->student->name ?? '—' }}</p>
                                    </div>
                                </td>
                                <td><p class="text-sm mb-0">{{ $a->course->name ?? '—' }}</p></td>
                                <td class="text-center"><span class="text-sm">{{ $a->date->format('d/m/Y') }}</span></td>
                                <td class="text-center"><span class="badge badge-sm bg-gradient-{{ $as[0] }}">{{ $as[1] }}</span></td>
                                <td><p class="text-xs text-secondary mb-0">{{ Str::limit($a->notes ?? '', 40) }}</p></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('education.attendance.edit', $a) }}" class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('education.attendance.destroy', $a) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar este registro?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-outline-danger mb-0 px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-secondary">No hay registros de asistencia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($attendances->hasPages())
                <div class="px-4 py-3 border-top">{{ $attendances->links() }}</div>
                @endif
            </div>
        </div>

    </div>
    <x-app.footer />
</main>
</x-app-layout>
