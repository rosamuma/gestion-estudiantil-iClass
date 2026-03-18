<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Docentes</h4>
                <p class="text-secondary text-sm mb-0">{{ $teachers->total() }} docente(s) registrados</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('education.teachers.create') }}" class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i> Nuevo Docente
                </a>
            </div>
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
                            placeholder="Buscar por nombre o especialidad…" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos</option>
                            <option value="active"   {{ request('status')==='active'  ?'selected':'' }}>Activo</option>
                            <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-dark btn-sm w-100">Buscar</button></div>
                    <div class="col-md-3"><a href="{{ route('education.teachers.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a></div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($teachers as $t)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-xs h-100" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="me-3 text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width:48px;height:48px;background:#1e293b;border-radius:12px;font-size:16px;">
                                {{ strtoupper(substr($t->name, 0, 2)) }}
                            </div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <h6 class="font-weight-bold mb-0 text-truncate">{{ $t->name }}</h6>
                                <p class="text-xs text-secondary mb-0 text-truncate">{{ $t->email }}</p>
                                @if($t->specialty)
                                    <span class="badge mt-1 text-dark" style="background:#f1f5f9;font-size:10px;">{{ $t->specialty }}</span>
                                @endif
                            </div>
                            <span class="badge badge-sm bg-gradient-{{ $t->status === 'active' ? 'success' : 'secondary' }} ms-2 flex-shrink-0">
                                {{ $t->status === 'active' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <hr class="horizontal dark my-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-center">
                                <p class="text-xs text-secondary mb-0">Cursos</p>
                                <h5 class="font-weight-bold mb-0">{{ $t->courses_count }}</h5>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('education.teachers.edit', $t) }}" class="btn btn-xs btn-outline-secondary px-2 py-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('education.teachers.destroy', $t) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar a {{ addslashes($t->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-xs btn-outline-danger px-2 py-1"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-xs p-5 text-center" style="border-radius:14px;">
                    <i class="fas fa-chalkboard-teacher fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">No hay docentes registrados.</p>
                    <a href="{{ route('education.teachers.create') }}" class="btn btn-dark btn-sm mx-auto">Registrar Docente</a>
                </div>
            </div>
            @endforelse
        </div>

        @if($teachers->hasPages())
        <div class="mt-2">{{ $teachers->links() }}</div>
        @endif

    </div>
    <x-app.footer />
</main>
</x-app-layout>
