<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Calificaciones</h4>
                <p class="text-secondary text-sm mb-0">{{ $grades->total() }} registro(s)</p>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('education.grades.create') }}" class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i> Nueva Calificación
                </a>
            </div>
            @endif
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
                <form method="GET" class="row g-2 align-items-center">

                    <div class="col-md-4">
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
                        <select name="period" class="form-select form-select-sm">
                            <option value="">Período</option>
                            @foreach($periods as $p)
                                <option value="{{ $p }}" {{ request('period') === $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Estado</option>
                            <option value="approved" {{ request('status')==='approved' ? 'selected':'' }}>✅ Aprobado</option>
                            <option value="failed" {{ request('status')==='failed' ? 'selected':'' }}>❌ Reprobado</option>
                            <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>⏳ Sin nota</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-sm w-50 mb-0">Filtrar</button>
                        <a href="{{ route('education.grades.index') }}" class="btn btn-outline-secondary btn-sm w-50 mb-0">
                            Limpiar
                        </a>
                    </div>

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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Período</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 1</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 2</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 3</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nota 4</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Promedio</th>
                                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                <th class="pe-4"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $g)
                            @php
                                $avg    = $g->average;
                                $color  = $avg === null ? 'text-secondary' : ($avg >= 8 ? 'text-success' : ($avg >= 6 ? 'text-warning' : 'text-danger'));
                                $status = $avg === null ? ['secondary','Sin nota'] : ($avg >= 6 ? ['success','Aprobado'] : ['danger','Reprobado']);
                            @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:32px;height:32px;background:#1e293b;border-radius:8px;font-size:11px;">
                                            {{ strtoupper(substr($g->student->name ?? '??', 0, 2)) }}
                                        </div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $g->student->name ?? '—' }}</p>
                                    </div>
                                </td>
                                <td><p class="text-sm mb-0">{{ $g->course->name ?? '—' }}</p></td>
                                <td class="text-center"><span class="badge bg-light text-dark text-xs">{{ $g->period }}</span></td>
                                <td class="text-center text-sm">{{ $g->grade_1 ?? '—' }}</td>
                                <td class="text-center text-sm">{{ $g->grade_2 ?? '—' }}</td>
                                <td class="text-center text-sm">{{ $g->grade_3 ?? '—' }}</td>
                                <td class="text-center text-sm">{{ $g->grade_4 ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="font-weight-bold {{ $color }}">{{ $avg ?? '—' }}</span>
                                    <br><span class="badge badge-sm bg-gradient-{{ $status[0] }}" style="font-size:9px;">{{ $status[1] }}</span>
                                </td>
                                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                <td class="text-end pe-4">
                                    <a href="{{ route('education.grades.edit', $g) }}" 
                                    class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button 
                                        type="button"
                                        class="btn btn-xs btn-outline-danger mb-0 px-2 py-1 btn-delete"
                                        data-url="{{ route('education.grades.destroy', $g) }}"
                                        data-avg="{{ $g->average }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-5 text-secondary">
                                No hay calificaciones registradas.
                                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                                    <a href="{{ route('education.grades.create') }}">Registrar la primera</a>
                                @endif
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($grades->hasPages())
                <div class="px-4 py-3 border-top">{{ $grades->links() }}</div>
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
                <h5 class="modal-title">Eliminar Registro de calificaciones</h5>
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
                    let avg = this.dataset.avg;

                    message.textContent = `¿Seguro que deseas eliminar el registro con promedio "${avg ?? 'sin nota'}"?`;

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
</x-app-layout>







