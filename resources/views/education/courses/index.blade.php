<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />

    <div class="px-4 py-5 container-fluid">

        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Cursos</h4>
                <p class="text-secondary text-sm mb-0">{{ $courses->total() }} curso(s) registrados</p>
            </div>

            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
            <div class="ms-auto">
                <a href="{{ route('education.courses.create') }}"
                    class="btn btn-dark btn-sm mb-0"
                    style="border-radius:10px;">
                        <i class="fas fa-plus me-1"></i> Nuevo Curso
                </a>
            </div>
            @endif
        </div>

        {{-- Mini stats --}}
        <div class="row mb-4">
            @foreach([['Total','total','#64748b'],['Activos','active','#10b981'],['Pendientes','pending','#f59e0b'],['Finalizados','finished','#6366f1']] as [$lbl,$key,$clr])
            <div class="col-6 col-md-3 mb-2">
                <div class="card border-0 shadow-xs text-center p-3" style="border-radius:12px;border-top:3px solid {{ $clr }} !important;">
                    <h4 class="font-weight-bold mb-0" style="color:{{ $clr }};">{{ $stats[$key] }}</h4>
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
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Buscar por nombre o código…" 
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Todos los estados</option>
                            <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Activo</option>
                            <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>Pendiente</option>
                            <option value="finished" {{ request('status')==='finished' ? 'selected':'' }}>Finalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-sm w-50 mb-0">Filtrar</button>
                        <a href="{{ route('education.courses.index') }}" class="btn btn-outline-secondary btn-sm w-50 mb-0">
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Curso</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Docente</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Créditos</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Inscritos</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>

                            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                            <th class="pe-4"></th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>

                        @forelse($courses as $c)
                        <tr style="border-bottom:1px solid #f1f5f9;">

                            <td class="ps-4">
                                <p class="text-sm font-weight-bold mb-0">{{ $c->name }}</p>
                                <p class="text-xs text-secondary mb-0">{{ $c->code ?? '—' }}</p>
                            </td>

                            {{-- DOCENTE --}}
                            <td>
                                @if($c->teacher)
                                    <p class="text-sm mb-0">{{ $c->teacher->name }}</p>
                                @else
                                    <p class="text-sm mb-0 text-secondary">Sin asignar</p>
                                @endif
                            </td>

                            <td>
                                <p class="text-sm mb-0">{{ $c->program->name ?? '—' }}</p>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark">
                                    {{ $c->credits }} cr.
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="font-weight-bold text-sm">
                                    {{ $c->students_count }}
                                </span>
                            </td>

                            <td class="text-center">
                                @php
                                $cs = [
                                    'active'=>['success','Activo'],
                                    'pending'=>['warning','Pendiente'],
                                    'finished'=>['secondary','Finalizado']
                                ][$c->status] ?? ['secondary',$c->status];
                                @endphp

                                <span class="badge badge-sm bg-gradient-{{ $cs[0] }}">
                                    {{ $cs[1] }}
                                </span>
                            </td>

                            @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                            <td class="text-end pe-4">

                                <a href="{{ route('education.courses.edit', $c) }}"
                                   class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    type="button"
                                    class="btn btn-xs btn-outline-danger mb-0 px-2 py-1 btn-delete"
                                    data-url="{{ route('education.courses.destroy', $c) }}"
                                    data-name="{{ $c->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>

                            @endif

                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                No hay cursos.
                                <a href="{{ route('education.courses.create') }}">
                                    Crear el primero
                                </a>
                            </td>
                        </tr>
                        @endforelse

                        </tbody>

                    </table>
                </div>

                @if($courses->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $courses->links() }}
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
        <h5 class="modal-title">Eliminar curso</h5>
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

        let courseId = null;

        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const message = document.getElementById('deleteMessage');
        const deleteForm = document.getElementById('deleteForm');

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {

                deleteUrl  = this.dataset.url;
                let name = this.dataset.name;

                message.textContent = `¿Seguro que deseas eliminar el curso "${name}"?`;

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
