@extends('layouts.app')

@section('title', 'Listado de Mascotas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1 text-dark">
            Mascotas
        </h2>
        <p class="text-muted small mb-0">Listado y gestión de pacientes de Veterinaria Chacabuco</p>
    </div>
    <a href="{{ route('mascotas.create') }}" class="btn btn-primary">
        + Registrar Mascota
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('mascotas.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="buscar" class="form-label small fw-semibold text-secondary">Buscar mascota o dueño</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="buscar" name="buscar" value="{{ $buscar }}" placeholder="Nombre, especie, raza o dueño...">
                </div>
            </div>
            <div class="col-md-3">
                <label for="orden" class="form-label small fw-semibold text-secondary">Ordenar por</label>
                <select class="form-select" id="orden" name="orden">
                    <option value="id" {{ $orden === 'id' ? 'selected' : '' }}>ID (Registro)</option>
                    <option value="nombre" {{ $orden === 'nombre' ? 'selected' : '' }}>Nombre</option>
                    <option value="especie" {{ $orden === 'especie' ? 'selected' : '' }}>Especie</option>
                    <option value="raza" {{ $orden === 'raza' ? 'selected' : '' }}>Raza</option>
                    <option value="edad" {{ $orden === 'edad' ? 'selected' : '' }}>Edad</option>
                    <option value="peso" {{ $orden === 'peso' ? 'selected' : '' }}>Peso</option>
                    <option value="created_at" {{ $orden === 'created_at' ? 'selected' : '' }}>Fecha de alta</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="direccion" class="form-label small fw-semibold text-secondary">Sentido</label>
                <select class="form-select" id="direccion" name="direccion">
                    <option value="asc" {{ $direccion === 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" {{ $direccion === 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filtrar
                </button>
                @if(!empty($buscar) || $orden !== 'id' || $direccion !== 'desc')
                    <a href="{{ route('mascotas.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
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
            Registros encontrados: {{ $mascotas->total() }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 70px;">ID</th>
                    <th>Nombre</th>
                    <th>Especie / Raza</th>
                    <th>Edad</th>
                    <th>Peso</th>
                    <th>Dueño</th>
                    <th>Teléfono</th>
                    <th class="text-center">Consultas</th>
                    <th class="text-end pe-4" style="width: 190px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mascotas as $mascota)
                    <tr>
                        <td class="text-center fw-bold text-secondary">#{{ $mascota->id }}</td>
                        <td>
                            <a href="{{ route('mascotas.show', $mascota) }}" class="fw-bold text-decoration-none text-primary">
                                {{ $mascota->nombre }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border me-1">{{ $mascota->especie }}</span>
                            <span class="text-muted small">{{ $mascota->raza }}</span>
                        </td>
                        <td>{{ $mascota->edad }} {{ $mascota->edad === 1 ? 'año' : 'años' }}</td>
                        <td>{{ number_format($mascota->peso, 2) }} kg</td>
                        <td>{{ $mascota->nombre_dueno }}</td>
                        <td>
                            <a href="tel:{{ $mascota->telefono_dueno }}" class="text-decoration-none text-muted small">
                                <i class="bi bi-telephone me-1"></i>{{ $mascota->telefono_dueno }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('mascotas.show', $mascota) }}" class="badge rounded-pill bg-info text-dark text-decoration-none px-3 py-2">
                                <i class="bi bi-file-medical me-1"></i>{{ $mascota->consultas_count }}
                            </a>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('mascotas.show', $mascota) }}" class="btn btn-outline-info" title="Ver detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('mascotas.edit', $mascota) }}" class="btn btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('mascotas.destroy', $mascota) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar a {{ $mascota->nombre }} y todas sus consultas médicas asociadas?');">
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
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                <p class="mb-2">No se encontraron mascotas registradas con los criterios ingresados.</p>
                                <a href="{{ route('mascotas.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i> Registrar la primera mascota
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($mascotas->hasPages())
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            {{ $mascotas->links() }}
        </div>
    @endif
</div>
@endsection
