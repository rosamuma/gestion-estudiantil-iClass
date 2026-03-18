<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.courses.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <div>
                <h4 class="font-weight-bold mb-0">{{ isset($course) ? 'Editar Curso' : 'Nuevo Curso' }}</h4>
                <p class="text-secondary text-sm mb-0">{{ isset($course) ? 'Actualiza la información del curso' : 'Registra un nuevo curso académico' }}</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-xs" style="border-radius:16px;">
                    <div class="card-body p-4">

                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" style="border-radius:10px;">
                                <i class="fas fa-exclamation-triangle me-2"></i><strong>Corrige los errores:</strong>
                                <ul class="mb-0 mt-2">@foreach($errors->all() as $e)<li class="text-sm">{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form action="{{ isset($course) ? route('education.courses.update', $course) : route('education.courses.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($course)) @method('PUT') @endif

                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Información del Curso</h6>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nombre del curso <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $course->name ?? '') }}" placeholder="Ej: Cálculo Diferencial" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Código</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code', $course->code ?? '') }}" placeholder="MAT-101">
                                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Docente</label>
                                    <select name="teacher_id" class="form-control">
                                        <option value="">— Sin asignar —</option>
                                        @foreach($teachers as $t)
                                            <option value="{{ $t->id }}" {{ old('teacher_id', $course->teacher_id ?? '') == $t->id ? 'selected' : '' }}>
                                                {{ $t->name }} ({{ $t->specialty }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Programa académico</label>
                                    <select name="program_id" class="form-control">
                                        <option value="">— Sin programa —</option>
                                        @foreach($programs as $p)
                                            <option value="{{ $p->id }}" {{ old('program_id', $course->program_id ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Créditos <span class="text-danger">*</span></label>
                                    <select name="credits" class="form-control" required>
                                        @for($i=1;$i<=10;$i++)
                                            <option value="{{ $i }}" {{ old('credits', $course->credits ?? 3) == $i ? 'selected' : '' }}>{{ $i }} crédito(s)</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="active"   {{ old('status', $course->status ?? 'active') === 'active'   ? 'selected':'' }}>✅ Activo</option>
                                        <option value="pending"  {{ old('status', $course->status ?? '') === 'pending'  ? 'selected':'' }}>⏳ Pendiente</option>
                                        <option value="finished" {{ old('status', $course->status ?? '') === 'finished' ? 'selected':'' }}>✔️ Finalizado</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Descripción</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Descripción del contenido del curso…">{{ old('description', $course->description ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                                <a href="{{ route('education.courses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($course) ? 'Actualizar' : 'Crear Curso' }}
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
