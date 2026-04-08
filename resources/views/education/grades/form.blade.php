<x-app-layout>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />
    <div class="px-4 py-5 container-fluid">

        <div class="d-flex align-items-center mb-5 justify-content-between">
            <div class="ms-4 px-2">
                <h4 class="font-weight-bold mb-0">{{ isset($grade) ? 'Editar Calificación' : 'Nueva Calificación' }}</h4>
                <p class="text-secondary text-sm mb-0">El promedio se calcula automáticamente</p>
            </div>
            <a href="{{ route('education.grades.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
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

                        <form action="{{ isset($grade) ? route('education.grades.update', $grade) : route('education.grades.store') }}"
                              method="POST">
                            @csrf
                            @if(isset($grade)) @method('PUT') @endif

                            @unless(isset($grade))
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-sm font-weight-bold">Estudiante <span class="text-danger">*</span></label>
                                    <select name="student_id" class="form-control" required>
                                        <option value="">— Seleccionar —</option>
                                        @foreach($students as $s)
                                            <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }} ({{ $s->student_code ?? $s->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-sm font-weight-bold">Curso <span class="text-danger">*</span></label>
                                    <select name="course_id" class="form-control" required>
                                        <option value="">— Seleccionar —</option>
                                        @foreach($courses as $c)
                                            <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Período <span class="text-danger">*</span></label>
                                <input type="text" name="period" class="form-control" value="{{ old('period') }}" placeholder="Ej: 2024-1" required>
                            </div>
                            @else
                            <div class="alert border-0 mb-3 p-3" style="background:#f8fafc;border-radius:10px;">
                                <p class="text-sm mb-0"><strong>Estudiante:</strong> {{ $grade->student->name }}</p>
                                <p class="text-sm mb-0"><strong>Curso:</strong> {{ $grade->course->name }}</p>
                                <p class="text-sm mb-0"><strong>Período:</strong> {{ $grade->period }}</p>
                            </div>
                            @endunless

                            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3 mt-3">Notas (0 – 10)</h6>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nota 1</label>
                                    <input type="number" name="grade_1" step="0.01" min="0" max="10"
                                        class="form-control text-center @error('grade_1') is-invalid @enderror"
                                        value="{{ old('grade_1', $grade->grade_1 ?? '') }}"
                                        id="g1" 
                                        oninput="this.value = Math.max(0, Math.min(10, this.value)); calcAvg();"
                                        onblur="calcAvg()">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nota 2</label>
                                    <input type="number" name="grade_2" step="0.01" min="0" max="10"
                                        class="form-control text-center"
                                        value="{{ old('grade_2', $grade->grade_2 ?? '') }}"
                                        id="g2" 
                                        oninput="this.value = Math.max(0, Math.min(10, this.value)); calcAvg();"
                                        onblur="calcAvg()">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nota 3</label>
                                    <input type="number" name="grade_3" step="0.01" min="0" max="10"
                                        class="form-control text-center" 
                                        value="{{ old('grade_3', $grade->grade_3 ?? '') }}"
                                        id="g3" 
                                        oninput="this.value = Math.max(0, Math.min(10, this.value)); calcAvg();"
                                        onblur="calcAvg()">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-sm font-weight-bold">Nota 4</label>
                                    <input type="number" name="grade_4" step="0.01" min="0" max="10"
                                        class="form-control text-center"
                                        value="{{ old('grade_4', $grade->grade_4 ?? '') }}"
                                        id="g4" 
                                        oninput="this.value = Math.max(0, Math.min(10, this.value)); calcAvg();"
                                        onblur="calcAvg()">
                                </div>
                            </div>

                            {{-- Promedio en vivo --}}
                            <div class="text-center p-3 mb-3" style="background:#f8fafc;border-radius:12px;">
                                <p class="text-secondary text-xs mb-1">Promedio calculado</p>
                                <h2 class="font-weight-bold mb-0" id="avg-display" style="color:#1e293b;">—</h2>
                                <span id="avg-badge" class="badge mt-1" style="font-size:11px;"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-sm font-weight-bold">Observaciones</label>
                                <textarea name="notes" class="form-control" rows="2"
                                    placeholder="Notas adicionales…">{{ old('notes', $grade->notes ?? '') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('education.grades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save me-1"></i>{{ isset($grade) ? 'Actualizar' : 'Guardar' }}
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

@push('scripts')
<script>
    function calcAvg() {

        const weights = [0.2, 0.2, 0.3, 0.3];

        const inputs = [
            document.getElementById('g1'),
            document.getElementById('g2'),
            document.getElementById('g3'),
            document.getElementById('g4')
        ];

        let total = 0;
        let weightSum = 0;

        inputs.forEach((input, i) => {
            let val = parseFloat(input.value);

            if (!isNaN(val)) {

                if (val < 0) val = 0;
                if (val > 10) val = 10;

                input.value = val;

                total += val * weights[i];
                weightSum += weights[i];
            }
        });

        const d = document.getElementById('avg-display');
        const b = document.getElementById('avg-badge');

        if (weightSum === 0) {
            d.textContent = '—';
            b.textContent = '';
            return;
        }

        const avg = total / weightSum;

        d.style.transform = 'scale(1.2)';
        setTimeout(() => d.style.transform = 'scale(1)', 150);

        d.textContent = avg.toFixed(2);

        if (avg < 6) {
            d.style.color = '#ef4444';
            b.textContent = 'Reprobado';
            b.className = 'badge bg-danger mt-1';
        } else if (avg < 8) {
            d.style.color = '#f59e0b';
            b.textContent = 'Aprobado';
            b.className = 'badge bg-warning mt-1';
        } else if (avg < 9) {
            d.style.color = '#3b82f6';
            b.textContent = 'Sobresaliente';
            b.className = 'badge bg-info mt-1';
        } else {
            d.style.color = '#10b981';
            b.textContent = 'Excelente';
            b.className = 'badge bg-success mt-1';
        }
    }

    document.addEventListener('DOMContentLoaded', calcAvg);
</script>

@endpush

<style>
#avg-display {
    transition: all 0.2s ease;
}
</style>
</x-app-layout>
