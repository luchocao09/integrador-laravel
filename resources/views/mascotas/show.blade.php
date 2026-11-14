@extends('layouts.app')

@section('title', 'Ficha de ' . $mascota->nombre)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">
            <i class="bi bi-person-badge text-primary me-2"></i>Ficha de Paciente: {{ $mascota->nombre }}
        </h2>
        <p class="text-muted small mb-0">Información general e historial médico de la mascota</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('mascotas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
        <a href="{{ route('mascotas.edit', $mascota) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Editar Mascota
        </a>
        <form action="{{ route('mascotas.destroy', $mascota) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar a esta mascota y todas sus consultas asociadas?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="bi bi-shield-shaded me-1"></i> Datos de la Mascota
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Nombre:</span>
                        <span class="fw-bold">{{ $mascota->nombre }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Especie:</span>
                        <span><span class="badge bg-primary">{{ $mascota->especie }}</span></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Raza:</span>
                        <span>{{ $mascota->raza }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Edad:</span>
                        <span>{{ $mascota->edad }} {{ $mascota->edad === 1 ? 'año' : 'años' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Peso:</span>
                        <span>{{ number_format($mascota->peso, 2) }} kg</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Fecha de Registro:</span>
                        <span>{{ $mascota->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="bi bi-person-lines-fill me-1"></i> Responsable a Cargo
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Nombre del Dueño:</span>
                        <span class="fw-bold">{{ $mascota->nombre_dueno }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Teléfono de Contacto:</span>
                        <span>
                            <a href="tel:{{ $mascota->telefono_dueno }}" class="text-decoration-none fw-semibold">
                                <i class="bi bi-telephone-outbound me-1"></i>{{ $mascota->telefono_dueno }}
                            </a>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted fw-semibold">Total de Consultas:</span>
                        <span><span class="badge bg-secondary">{{ $mascota->consultas->count() }} registradas</span></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-0 fw-bold text-dark">
                <i class="bi bi-clipboard2-pulse text-primary me-2"></i>Historial de Consultas Médicas
            </h5>
            <small class="text-muted">Atenciones veterinarias recibidas por {{ $mascota->nombre }}</small>
        </div>
        <a href="{{ route('consultas.create', ['mascota_id' => $mascota->id]) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Nueva Consulta
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 120px;">Fecha</th>
                    <th>Motivo</th>
                    <th>Veterinario</th>
                    <th>Costo</th>
                    <th>Diagnóstico</th>
                    <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mascota->consultas as $consulta)
                    <tr>
                        <td class="fw-semibold text-secondary">
                            {{ $consulta->fecha_consulta->format('d/m/Y') }}
                        </td>
                        <td class="fw-bold text-dark">{{ $consulta->motivo }}</td>
                        <td>{{ $consulta->veterinario }}</td>
                        <td class="fw-semibold text-success">${{ number_format($consulta->costo, 2, ',', '.') }}</td>
                        <td>
                            <span class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                {{ $consulta->diagnostico }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('consultas.show', $consulta) }}" class="btn btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta consulta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-clipboard-x fs-2 d-block mb-1 text-secondary"></i>
                            Esta mascota no tiene consultas médicas registradas todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
