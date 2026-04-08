<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" style="background:#f5f7fb;">
    <x-app.navbar />

    <div class="px-4 py-4 container-fluid">

        <!-- Header -->
        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Asistencia</h4>
                <p class="text-muted text-sm mb-0">Control de asistencia por curso</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('education.attendance.create') }}" 
                    class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i>Registrar Asistencia
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            @foreach([
                ['Presentes',$presentToday,'#22c55e'],
                ['Ausentes',$absentToday,'#ef4444'],
                ['Justificados',$justToday,'#3b82f6'],
                ['Asistencia %',$avgPct.'%','#f59e0b']
            ] as [$lbl,$val,$clr])

            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 shadow-sm p-3 text-center" style="border-radius:16px;">
                    <h4 class="fw-bold mb-1" style="color:{{ $clr }}">{{ $val }}</h4>
                    <p class="text-xs text-muted mb-0">{{ $lbl }}</p>
                </div>
            </div>

            @endforeach
        </div>

        @if(session('success'))
            <div class="alert border-0 shadow-sm" style="border-radius:12px; background:#ecfdf5; color:#065f46;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="card border-0 shadow-xs mb-4" style="border-radius:14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2 align-items-center">

                    <div class="col-md-3">
                        <select name="course_id" class="form-select form-select-sm">
                            <option value="">Curso</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input 
                            type="date" 
                            title="Desde"
                            name="date_from" 
                            class="form-control form-control-sm"
                            value="{{ request('date_from') }}"
                            placeholder="Desde">
                    </div>
                    <div class="col-md-2">
                        <input 
                            type="date" 
                            title="Hasta"
                            name="date_to" 
                            class="form-control form-control-sm"
                            value="{{ request('date_to') }}"
                            placeholder="Hasta">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Estado</option>
                            <option value="present" {{ request('status')==='present'?'selected':'' }}>Presente</option>
                            <option value="absent" {{ request('status')==='absent'?'selected':'' }}>Ausente</option>
                            <option value="justified" {{ request('status')==='justified'?'selected':'' }}>Justificado</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-sm w-50 mb-0">
                            Filtrar
                        </button>

                        <a href="{{ route('education.attendance.index') }}" 
                        class="btn btn-outline-secondary btn-sm w-50 mb-0">
                        Limpiar
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- Tabla -->
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="table-responsive">

                <table class="table align-items-center mb-0">
                    <thead style="background:#f1f5f9;">
                        <tr>
                            <th class="text-xs text-muted ps-4">Estudiante</th>
                            <th class="text-xs text-muted">Curso</th>
                            <th class="text-xs text-muted text-center">Fecha</th>
                            <th class="text-xs text-muted text-center">Estado</th>
                            <th class="text-xs text-muted">Notas</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($attendances as $a)

                        @php
                            $colors = [
                                'present' => '#22c55e',
                                'absent' => '#ef4444',
                                'justified' => '#3b82f6'
                            ];
                            $color = $colors[$a->status] ?? '#64748b';
                        @endphp

                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        {{ strtoupper(substr($a->student->name ?? '??', 0, 2)) }}
                                    </div>
                                    <span class="ms-2 text-sm fw-semibold">
                                        {{ $a->student->name ?? '—' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-sm">{{ $a->course->name ?? '—' }}</td>

                            <td class="text-center text-sm">
                                {{ $a->date->format('d/m/Y') }}
                            </td>

                            <td class="text-center">
                                <span class="badge-soft" style="background:{{ $color }}20; color:{{ $color }};">
                                    @php
                                        $labels = [
                                            'present' => 'Presente',
                                            'absent' => 'Ausente',
                                            'justified' => 'Justificado'
                                        ];
                                    @endphp

                                    {{ $labels[$a->status] ?? $a->status }}
                                </span>
                            </td>

                            <td class="text-xs text-muted">
                                {{ Str::limit($a->notes ?? '', 40) }}
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('education.attendance.edit', $a) }}" 
                                    class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    type="button"
                                    class="btn btn-xs btn-outline-danger mb-0 px-2 py-1 btn-delete"
                                    data-url="{{ route('education.attendance.destroy', $a) }}"
                                    data-student="{{ $a->student->name ?? 'Estudiante' }}"
                                    data-date="{{ $a->date->format('d/m/Y') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No hay registros de asistencia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($attendances->hasPages())
                    <div class="p-3 border-top">
                        {{ $attendances->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

    <x-app.footer />

    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Eliminar asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="deleteMessage"></p>
            </div>

            <div class="modal-footer">
                <button id="confirmDelete" class="btn btn-danger">Sí, eliminar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let deleteUrl  = null;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const message = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {

                    deleteUrl  = this.dataset.url;
                    let student = this.dataset.student;
                    let date = this.dataset.date;

                    message.textContent = `¿Seguro que deseas la asistencia de "${student}" del ${date}?`;

                    modal.show();
                });

            });

            document.getElementById('confirmDelete').addEventListener('click', function () {

                deleteForm.action = deleteUrl;
                deleteForm.submit();

            });

        });
    </script>
</main>

<style>
/* Inputs */
.custom-input {
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-size:14px;
}

.custom-input:focus {
    border-color:#1e293b;
    box-shadow:0 0 0 2px rgba(30,41,59,0.1);
}

/* Avatar */
.avatar {
    width:32px;
    height:32px;
    background:#1e293b;
    color:#fff;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:12px;
    font-weight:bold;
}

/* Badge moderno */
.badge-soft {
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:500;
}
</style>

</x-app-layout>