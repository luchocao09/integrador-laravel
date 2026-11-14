@extends('layouts.app')

@section('title', 'Registrar Nueva Consulta')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1 text-dark">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Nueva Consulta Médica
                </h2>
                <p class="text-muted small mb-0">Registre la atención veterinaria brindada al paciente</p>
            </div>
            <a href="{{ route('consultas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver al listado
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('consultas.store') }}" method="POST">
                    @csrf

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-info-circle me-1"></i> Datos de la Consulta
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="mascota_id" class="form-label fw-semibold">Mascota (Paciente) <span class="text-danger">*</span></label>
                            <select class="form-select @error('mascota_id') is-invalid @enderror" id="mascota_id" name="mascota_id" required>
                                <option value="">-- Seleccionar Mascota --</option>
                                @foreach ($mascotas as $m)
                                    <option value="{{ $m->id }}" {{ (string)old('mascota_id', $mascotaIdSeleccionada) === (string)$m->id ? 'selected' : '' }}>
                                        {{ $m->nombre }} ({{ $m->especie }} - Dueño: {{ $m->nombre_dueno }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mascota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($mascotas->isEmpty())
                                <div class="form-text text-danger">
                                    No hay mascotas registradas. <a href="{{ route('mascotas.create') }}">Haga clic aquí para registrar una mascota primero</a>.
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_consulta" class="form-label fw-semibold">Fecha de Consulta <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_consulta') is-invalid @enderror" id="fecha_consulta" name="fecha_consulta" value="{{ old('fecha_consulta', date('Y-m-d')) }}" required>
                            @error('fecha_consulta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="motivo" class="form-label fw-semibold">Motivo de la Consulta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('motivo') is-invalid @enderror" id="motivo" name="motivo" value="{{ old('motivo') }}" placeholder="Ej: Control de vacunas, decaimiento, tos recurrente" required>
                            @error('motivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="veterinario" class="form-label fw-semibold">Veterinario a Cargo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('veterinario') is-invalid @enderror" id="veterinario" name="veterinario" value="{{ old('veterinario') }}" placeholder="Ej: Dr. Gómez" required>
                            @error('veterinario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="costo" class="form-label fw-semibold">Costo ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" max="999999.99" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" value="{{ old('costo') }}" placeholder="Ej: 15000.00" required>
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
                            <textarea class="form-control @error('diagnostico') is-invalid @enderror" id="diagnostico" name="diagnostico" rows="3" placeholder="Detalle la evaluación y hallazgos clínicos..." required>{{ old('diagnostico') }}</textarea>
                            @error('diagnostico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="tratamiento" class="form-label fw-semibold">Tratamiento e Indicaciones <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('tratamiento') is-invalid @enderror" id="tratamiento" name="tratamiento" rows="3" placeholder="Detalle la medicación indicada, dosis y pautas de cuidado..." required>{{ old('tratamiento') }}</textarea>
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
                            <i class="bi bi-check-lg me-1"></i> Guardar Consulta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
