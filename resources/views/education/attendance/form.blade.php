<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-4 container-fluid">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('education.attendance.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <div>
                <h4 class="font-weight-bold mb-0">{{ isset($attendance) ? 'Editar Asistencia' : 'Registrar Asistencia' }}</h4>
                <p class="text-secondary text-sm mb-0">Registra la asistencia de un estudiante</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-xs" style="border-radius:16px;">
                    <div class="card-body p-4">

                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" style="border-radius:10px;">
                                <ul class="mb-0">@foreach($errors->all() as $e)<li class="text-sm">{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form action="{{ isset($attendance) ? route('education.attendance.update', $attendance) : route('education.attendance.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($attendance)) @method('PUT') @endif

                            @unless(isset($attendance))
                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Estudiante <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control" required>
                                    <option value="">— Seleccionar estudiante —</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }} ({{ $s->student_code ?? $s->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Curso <span class="text-danger">*</span></label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">— Seleccionar curso —</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Fecha <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                            @else
                            <div class="p-3 mb-3" style="background:#f8fafc;border-radius:10px;">
                                <p class="text-sm mb-1"><strong>Estudiante:</strong> {{ $attendance->student->name }}</p>
                                <p class="text-sm mb-1"><strong>Curso:</strong> {{ $attendance->course->name }}</p>
                                <p class="text-sm mb-0"><strong>Fecha:</strong> {{ $attendance->date->format('d/m/Y') }}</p>
                            </div>
                            @endunless

                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Estado <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach(['present'=>['success','✅','Presente'],'absent'=>['danger','❌','Ausente'],'justified'=>['info','📋','Justificado']] as $val=>[$color,$icon,$label])
                                    <div class="col-4">
                                        <input type="radio" class="btn-check" name="status" id="st-{{ $val }}" value="{{ $val }}"
                                            {{ old('status', $attendance->status ?? 'present') === $val ? 'checked' : '' }}>
                                        <label class="btn btn-outline-{{ $color }} w-100 py-3" for="st-{{ $val }}">
                                            <span class="d-block fs-5">{{ $icon }}</span>
                                            <span class="text-xs">{{ $label }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Observaciones</label>
                                <textarea name="notes" class="form-control" rows="2"
                                    placeholder="Motivo de ausencia, justificación…">{{ old('notes', $attendance->notes ?? '') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('education.attendance.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($attendance) ? 'Actualizar' : 'Guardar' }}
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
