<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        {{-- Header --}}
        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Estudiantes</h4>
                <p class="text-secondary text-sm mb-0">{{ $students->total() }} estudiante(s) registrados</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('education.students.create') }}" class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i> Nuevo Estudiante
                </a>
            </div>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs" role="alert" style="border-radius:12px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="card border-0 shadow-xs mb-4" style="border-radius:14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2 align-items-center">

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Buscar por nombre, email o código…"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="program_id" class="form-select form-select-sm">
                            <option value="">Programa</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}" {{ request('program_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Estado</option>
                            <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Activo</option>
                            <option value="inactive" {{ request('status')==='inactive' ? 'selected':'' }}>Inactivo</option>
                            <option value="graduated" {{ request('status')==='graduated' ? 'selected':'' }}>Graduado</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-dark btn-sm w-50 mb-0">Buscar</button>
                        <a href="{{ route('education.students.index') }}" class="btn btn-outline-secondary btn-sm w-50 mb-0">
                            Limpiar
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="card border-0 shadow-xs" style="border-radius:14px;overflow:hidden;">
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Estudiante</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Programa</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sem.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estado</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Promedio</th>
                                <th class="text-secondary opacity-7 pe-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $s)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:36px;height:36px;background:#1e293b;border-radius:10px;font-size:12px;">
                                            {{ strtoupper(substr($s->name,0,2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-weight-bold mb-0">{{ $s->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $s->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-xs font-weight-bold">{{ $s->student_code ?? '—' }}</span></td>
                                <td><p class="text-sm mb-0">{{ $s->program->name ?? '—' }}</p></td>
                                <td class="text-center"><span class="badge bg-light text-dark">{{ $s->semester }}°</span></td>
                                <td class="text-center">
                                    @php $sc=['active'=>['success','Activo'],'inactive'=>['secondary','Inactivo'],'graduated'=>['info','Graduado']][$s->status]??['secondary',$s->status]; @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $sc[0] }}">{{ $sc[1] }}</span>
                                </td>
                                <td class="text-center">
                                    @if($s->average !== null)
                                        <span class="font-weight-bold {{ $s->average>=6?'text-success':'text-danger' }}">{{ $s->average }}</span>
                                    @else
                                        <span class="text-secondary">—</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">

                                    <a href="{{ route('education.students.edit', $s) }}"
                                    class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button 
                                        type="button"
                                        class="btn btn-xs btn-outline-danger mb-0 px-2 py-1 btn-delete"
                                        data-id="{{ $s->id }}"
                                        data-name="{{ $s->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                    <td colspan="7" class="text-center py-5 text-secondary">
                                    No se encontraron estudiantes.
                                    <a href="{{ route('education.students.create') }}">Registrar el primero</a>
                                </td>
                            </tr>
                            @endforelse
                            <form id="deleteForm" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </tbody>
                    </table>
                </div>
                @if($students->hasPages())
                <div class="px-4 py-3 border-top">{{ $students->links() }}</div>
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
                <h5 class="modal-title">Eliminar estudiante</h5>
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

            let studentId = null;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const message = document.getElementById('deleteMessage');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {

                    studentId = this.dataset.id;
                    let name = this.dataset.name;

                    message.textContent = `¿Seguro que deseas eliminar a ${name}?`;

                    modal.show();
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function () {

                deleteForm.action = `/education/students/${studentId}`;
                deleteForm.submit();

            });

        });
    </script>
</main>
</x-app-layout>
