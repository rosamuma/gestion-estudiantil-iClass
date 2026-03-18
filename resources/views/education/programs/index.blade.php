<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-sm-flex align-items-center mb-4">
            <div>
                <h4 class="font-weight-bold mb-0">Programas Académicos</h4>
                <p class="text-secondary text-sm mb-0">{{ $programs->total() }} programa(s) activos</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('education.programs.create') }}" class="btn btn-dark btn-sm mb-0">
                    <i class="fas fa-plus me-1"></i> Nuevo Programa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs" style="border-radius:12px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filtro de búsqueda --}}
        <div class="card border-0 shadow-xs mb-4" style="border-radius:14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Buscar por nombre o código…" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-dark btn-sm w-100">Buscar</button></div>
                    <div class="col-md-2"><a href="{{ route('education.programs.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a></div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-xs" style="border-radius:14px;overflow:hidden;">
            <div class="card-body px-0 py-0">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Programa</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Código</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Duración</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Estudiantes</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Cursos</th>
                                <th class="pe-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $p)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:36px;height:36px;background:#eef2ff;border-radius:10px;">
                                            <i class="fas fa-university" style="color:#6366f1;font-size:14px;"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-weight-bold mb-0">{{ $p->name }}</p>
                                            @if($p->description)
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($p->description, 50) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="badge bg-light text-dark text-xs">{{ $p->code ?? '—' }}</span></td>
                                <td class="text-center"><span class="text-sm">{{ $p->duration_semesters }} sem.</span></td>
                                <td class="text-center">
                                    <span class="font-weight-bold text-sm" style="color:#3b82f6;">{{ $p->students_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="font-weight-bold text-sm" style="color:#10b981;">{{ $p->courses_count }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('education.programs.edit', $p) }}" class="btn btn-xs btn-outline-secondary mb-0 me-1 px-2 py-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('education.programs.destroy', $p) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar el programa {{ addslashes($p->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-outline-danger mb-0 px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-secondary">
                                No hay programas. <a href="{{ route('education.programs.create') }}">Crear el primero</a>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($programs->hasPages())
                <div class="px-4 py-3 border-top">{{ $programs->links() }}</div>
                @endif
            </div>
        </div>

    </div>
    <x-app.footer />
</main>
</x-app-layout>
