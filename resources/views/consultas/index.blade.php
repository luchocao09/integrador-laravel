@extends('layouts.app')

@section('title', 'Listado de Consultas Médicas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">
            <i class="bi bi-clipboard2-pulse text-primary me-2"></i>Consultas Médicas
        </h2>
        <p class="text-muted small mb-0">Registro y control de atenciones veterinarias</p>
    </div>
    <a href="{{ route('consultas.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Nueva Consulta
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('consultas.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="buscar" class="form-label small fw-semibold text-secondary">Buscar consulta</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="buscar" name="buscar" value="{{ $buscar }}" placeholder="Motivo, veterinario, mascota o dueño...">
                </div>
            </div>
            <div class="col-md-3">
                <label for="orden" class="form-label small fw-semibold text-secondary">Ordenar por</label>
                <select class="form-select" id="orden" name="orden">
                    <option value="fecha_consulta" {{ $orden === 'fecha_consulta' ? 'selected' : '' }}>Fecha de consulta</option>
                    <option value="costo" {{ $orden === 'costo' ? 'selected' : '' }}>Costo</option>
                    <option value="veterinario" {{ $orden === 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                    <option value="id" {{ $orden === 'id' ? 'selected' : '' }}>ID</option>
                    <option value="created_at" {{ $orden === 'created_at' ? 'selected' : '' }}>Fecha de registro</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="direccion" class="form-label small fw-semibold text-secondary">Sentido</label>
                <select class="form-select" id="direccion" name="direccion">
                    <option value="desc" {{ $direccion === 'desc' ? 'selected' : '' }}>Descendente</option>
                    <option value="asc" {{ $direccion === 'asc' ? 'selected' : '' }}>Ascendente</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filtrar
                </button>
                @if(!empty($buscar) || $orden !== 'fecha_consulta' || $direccion !== 'desc')
                    <a href="{{ route('consultas.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary">
            Registros encontrados: {{ $consultas->total() }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 70px;">ID</th>
                    <th style="width: 120px;">Fecha</th>
                    <th>Mascota</th>
                    <th>Dueño</th>
                    <th>Motivo de Atención</th>
                    <th>Veterinario</th>
                    <th>Costo</th>
                    <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consultas as $consulta)
                    <tr>
                        <td class="text-center fw-bold text-secondary">#{{ $consulta->id }}</td>
                        <td class="fw-semibold text-dark">
                            {{ $consulta->fecha_consulta->format('d/m/Y') }}
                        </td>
                        <td>
                            @if ($consulta->mascota)
                                <a href="{{ route('mascotas.show', $consulta->mascota) }}" class="fw-bold text-decoration-none text-primary">
                                    {{ $consulta->mascota->nombre }}
                                </a>
                                <span class="badge bg-light text-dark border ms-1">{{ $consulta->mascota->especie }}</span>
                            @else
                                <span class="text-muted fst-italic">Sin asignar</span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $consulta->mascota ? $consulta->mascota->nombre_dueno : '-' }}
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $consulta->motivo }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis border">
                                <i class="bi bi-person me-1"></i>{{ $consulta->veterinario }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">
                            ${{ number_format($consulta->costo, 2, ',', '.') }}
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
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                <p class="mb-2">No se encontraron consultas registradas con los criterios ingresados.</p>
                                <a href="{{ route('consultas.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i> Registrar la primera consulta
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($consultas->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $consultas->links() }}
        </div>
    @endif
</div>
@endsection
