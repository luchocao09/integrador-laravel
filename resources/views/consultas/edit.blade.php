@extends('layouts.app')

@section('title', 'Editar Consulta #' . $consulta->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1 text-dark">
                    Editar Consulta #{{ $consulta->id }}
                </h2>
                <p class="text-muted small mb-0">Actualice los datos de la atención médica</p>
            </div>
            <a href="{{ route('consultas.index') }}" class="btn btn-outline-secondary">
                &larr; Volver al listado
            </a>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('consultas.update', $consulta) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                        Datos de la Consulta
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="mascota_id" class="form-label fw-semibold">Mascota (Paciente) <span class="text-danger">*</span></label>
                            <select class="form-select @error('mascota_id') is-invalid @enderror" id="mascota_id" name="mascota_id" required>
                                <option value="">-- Seleccionar Mascota --</option>
                                @foreach ($mascotas as $m)
                                    <option value="{{ $m->id }}" {{ (string)old('mascota_id', $consulta->mascota_id) === (string)$m->id ? 'selected' : '' }}>
                                        {{ $m->nombre }} ({{ $m->especie }} - Dueño: {{ $m->nombre_dueno }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mascota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_consulta" class="form-label fw-semibold">Fecha de Consulta <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_consulta') is-invalid @enderror" id="fecha_consulta" name="fecha_consulta" value="{{ old('fecha_consulta', $consulta->fecha_consulta ? $consulta->fecha_consulta->format('Y-m-d') : '') }}" required>
                            @error('fecha_consulta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="motivo" class="form-label fw-semibold">Motivo de la Consulta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('motivo') is-invalid @enderror" id="motivo" name="motivo" value="{{ old('motivo', $consulta->motivo) }}" required>
                            @error('motivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="veterinario" class="form-label fw-semibold">Veterinario a Cargo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('veterinario') is-invalid @enderror" id="veterinario" name="veterinario" value="{{ old('veterinario', $consulta->veterinario) }}" required>
                            @error('veterinario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="costo" class="form-label fw-semibold">Costo ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="999999.99" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" value="{{ old('costo', $consulta->costo) }}" required>
                            @error('costo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-file-earmark-medical me-1"></i> Evaluación Médica
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label for="diagnostico" class="form-label fw-semibold">Diagnóstico Clínico <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('diagnostico') is-invalid @enderror" id="diagnostico" name="diagnostico" rows="3" required>{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                            @error('diagnostico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="tratamiento" class="form-label fw-semibold">Tratamiento e Indicaciones <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('tratamiento') is-invalid @enderror" id="tratamiento" name="tratamiento" rows="3" required>{{ old('tratamiento', $consulta->tratamiento) }}</textarea>
                            @error('tratamiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Actualizar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
