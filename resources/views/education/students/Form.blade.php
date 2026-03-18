<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.students.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <div>
                <h4 class="font-weight-bold mb-0">{{ isset($student) ? 'Editar Estudiante' : 'Nuevo Estudiante' }}</h4>
                <p class="text-secondary text-sm mb-0">{{ isset($student) ? 'Actualiza los datos del estudiante' : 'Registra un nuevo estudiante en la plataforma' }}</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-xs" style="border-radius:16px;">
                    <div class="card-body p-4">

                        @if($errors->any())
                            <div class="alert alert-danger border-0" style="border-radius:10px;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Por favor corrige los siguientes errores:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $e)<li class="text-sm">{{ $e }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ isset($student) ? route('education.students.update', $student) : route('education.students.store') }}"
                            method="POST">
                            @csrf
                            @if(isset($student)) @method('PUT') @endif

                            {{-- Sección datos personales --}}
                            <h6 class="font-weight-bold text-sm text-uppercase text-secondary mb-3 mt-1">Datos Personales</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nombre completo <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $student->name ?? '') }}" placeholder="Ej: María García López" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Correo electrónico <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $student->email ?? '') }}" placeholder="correo@ejemplo.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Sección académica --}}
                            <h6 class="font-weight-bold text-sm text-uppercase text-secondary mb-3 mt-2">Datos Académicos</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Código estudiantil</label>
                                    <input type="text" name="student_code" class="form-control @error('student_code') is-invalid @enderror"
                                        value="{{ old('student_code', $student->student_code ?? '') }}" placeholder="2024-001">
                                    @error('student_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Programa académico</label>
                                    <select name="program_id" class="form-control">
                                        <option value="">— Sin programa —</option>
                                        @foreach($programs as $p)
                                            <option value="{{ $p->id }}" {{ old('program_id', $student->program_id ?? '') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} ({{ $p->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Semestre <span class="text-danger">*</span></label>
                                    <select name="semester" class="form-control" required>
                                        @for($i=1;$i<=12;$i++)
                                            <option value="{{ $i }}" {{ old('semester', $student->semester ?? 1) == $i ? 'selected' : '' }}>{{ $i }}° Semestre</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="active"    {{ old('status', $student->status ?? 'active') === 'active'    ? 'selected' : '' }}>✅ Activo</option>
                                        <option value="inactive"  {{ old('status', $student->status ?? '') === 'inactive'  ? 'selected' : '' }}>⏸ Inactivo</option>
                                        <option value="graduated" {{ old('status', $student->status ?? '') === 'graduated' ? 'selected' : '' }}>🎓 Graduado</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Fecha de matrícula</label>
                                    <input type="date" name="enrollment_date" class="form-control"
                                        value="{{ old('enrollment_date', isset($student) ? $student->enrollment_date?->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Notas / Observaciones</label>
                                    <textarea name="notes" class="form-control" rows="3"
                                        placeholder="Observaciones adicionales sobre el estudiante…">{{ old('notes', $student->notes ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                                <a href="{{ route('education.students.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($student) ? 'Actualizar' : 'Registrar Estudiante' }}
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
