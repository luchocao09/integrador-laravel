@extends('layouts.app')

@section('title', 'Registrar Nueva Mascota')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1 text-dark">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Registrar Mascota
                </h2>
                <p class="text-muted small mb-0">Complete la ficha de ingreso de la nueva mascota</p>
            </div>
            <a href="{{ route('mascotas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver al listado
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('mascotas.store') }}" method="POST">
                    @csrf

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-tag me-1"></i> Datos de la Mascota
                    </h5>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Firulais" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="especie" class="form-label fw-semibold">Especie <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('especie') is-invalid @enderror" id="especie" name="especie" value="{{ old('especie') }}" placeholder="Ej: Canino, Felino, Ave" required>
                            @error('especie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="raza" class="form-label fw-semibold">Raza <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('raza') is-invalid @enderror" id="raza" name="raza" value="{{ old('raza') }}" placeholder="Ej: Labrador, Siames, Mestizo" required>
                            @error('raza')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="edad" class="form-label fw-semibold">Edad (años) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('edad') is-invalid @enderror" id="edad" name="edad" value="{{ old('edad') }}" min="0" max="100" placeholder="Ej: 3" required>
                            @error('edad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="peso" class="form-label fw-semibold">Peso (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('peso') is-invalid @enderror" id="peso" name="peso" value="{{ old('peso') }}" min="0.01" max="999.99" placeholder="Ej: 12.50" required>
                            @error('peso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-person me-1"></i> Datos del Dueño o Responsable
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nombre_dueno" class="form-label fw-semibold">Nombre del Dueño <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre_dueno') is-invalid @enderror" id="nombre_dueno" name="nombre_dueno" value="{{ old('nombre_dueno') }}" placeholder="Ej: Juan Pérez" required>
                            @error('nombre_dueno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telefono_dueno" class="form-label fw-semibold">Teléfono de Contacto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telefono_dueno') is-invalid @enderror" id="telefono_dueno" name="telefono_dueno" value="{{ old('telefono_dueno') }}" placeholder="Ej: 11-4567-8901" required>
                            @error('telefono_dueno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('mascotas.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Guardar Mascota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
