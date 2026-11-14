@extends('layouts.app')

@section('title', 'Consulta #' . $consulta->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">
            <i class="bi bi-file-earmark-medical text-primary me-2"></i>Consulta Médica #{{ $consulta->id }}
        </h2>
        <p class="text-muted small mb-0">Detalle de la atención realizada el {{ $consulta->fecha_consulta->format('d/m/Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('consultas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
        <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Editar
        </a>
        <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta consulta?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="bi bi-journal-medical me-1"></i> Información de la Consulta
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold d-block">Fecha de Consulta</label>
                        <span class="fs-6 fw-bold text-dark">{{ $consulta->fecha_consulta->format('d/m/Y') }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold d-block">Veterinario Responsable</label>
                        <span class="fs-6 fw-bold text-dark">{{ $consulta->veterinario }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold d-block">Motivo Principal</label>
                        <span class="fs-6 fw-bold text-dark">{{ $consulta->motivo }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-semibold d-block">Costo de la Atención</label>
                        <span class="fs-5 fw-bold text-success">${{ number_format($consulta->costo, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-semibold d-block mb-1">Diagnóstico Clínico</label>
                    <div class="p-3 bg-light rounded border text-dark">
                        {{ $consulta->diagnostico }}
                    </div>
                </div>

                <div>
                    <label class="text-muted small fw-semibold d-block mb-1">Tratamiento e Indicaciones</label>
                    <div class="p-3 bg-light rounded border text-dark">
                        {{ $consulta->tratamiento }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if ($consulta->mascota)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-shield-shaded me-1"></i> Datos del Paciente
                    </h5>
                    <a href="{{ route('mascotas.show', $consulta->mascota) }}" class="btn btn-sm btn-outline-primary">
                        Ver Ficha
                    </a>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="display-6 text-primary mb-1">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $consulta->mascota->nombre }}</h4>
                        <span class="badge bg-primary mt-1">{{ $consulta->mascota->especie }}</span>
                    </div>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Raza:</span>
                            <span class="fw-semibold">{{ $consulta->mascota->raza }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Edad:</span>
                            <span class="fw-semibold">{{ $consulta->mascota->edad }} {{ $consulta->mascota->edad === 1 ? 'año' : 'años' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Peso:</span>
                            <span class="fw-semibold">{{ number_format($consulta->mascota->peso, 2) }} kg</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Dueño:</span>
                            <span class="fw-semibold">{{ $consulta->mascota->nombre_dueno }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Teléfono:</span>
                            <span class="fw-semibold">{{ $consulta->mascota->telefono_dueno }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
