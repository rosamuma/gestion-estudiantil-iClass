<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.teachers.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <div>
                <h4 class="font-weight-bold mb-0">{{ isset($teacher) ? 'Editar Docente' : 'Nuevo Docente' }}</h4>
                <p class="text-secondary text-sm mb-0">Gestión de docentes de la institución</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-xs" style="border-radius:16px;">
                    <div class="card-body p-4">

                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" style="border-radius:10px;">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li class="text-sm">{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form action="{{ isset($teacher) ? route('education.teachers.update', $teacher) : route('education.teachers.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($teacher)) @method('PUT') @endif

                            <div class="row">
                                <div class="col-md-7 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nombre completo <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $teacher->name ?? '') }}" placeholder="Dr. Juan García" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="active"   {{ old('status', $teacher->status ?? 'active') === 'active'   ? 'selected':'' }}>✅ Activo</option>
                                        <option value="inactive" {{ old('status', $teacher->status ?? '') === 'inactive' ? 'selected':'' }}>⏸ Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Correo electrónico <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $teacher->email ?? '') }}" placeholder="docente@edu.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Especialidad</label>
                                    <input type="text" name="specialty" class="form-control"
                                        value="{{ old('specialty', $teacher->specialty ?? '') }}" placeholder="Ej: Matemáticas">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                                <a href="{{ route('education.teachers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($teacher) ? 'Actualizar' : 'Registrar Docente' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-app.footer />
</main>
</x-app-layout>
