<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.programs.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <div>
                <h4 class="font-weight-bold mb-0">{{ isset($program) ? 'Editar Programa' : 'Nuevo Programa Académico' }}</h4>
                <p class="text-secondary text-sm mb-0">Define los programas de estudio de la institución</p>
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

                        <form action="{{ isset($program) ? route('education.programs.update', $program) : route('education.programs.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($program)) @method('PUT') @endif

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nombre del programa <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $program->name ?? '') }}" placeholder="Ej: Ingeniería de Sistemas" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Código</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code', $program->code ?? '') }}" placeholder="ISI" maxlength="20">
                                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Duración (semestres) <span class="text-danger">*</span></label>
                                    <select name="duration_semesters" class="form-control" required>
                                        @for($i=2;$i<=16;$i+=2)
                                            <option value="{{ $i }}" {{ old('duration_semesters', $program->duration_semesters ?? 8) == $i ? 'selected' : '' }}>
                                                {{ $i }} semestres
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Descripción</label>
                                    <textarea name="description" class="form-control" rows="3"
                                        placeholder="Descripción del programa académico…">{{ old('description', $program->description ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                                <a href="{{ route('education.programs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($program) ? 'Actualizar' : 'Crear Programa' }}
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
