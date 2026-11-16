@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="text-center py-5">
    <h1 class="display-5 fw-bold mb-3">Veterinaria Chacabuco</h1>
    <p class="lead text-muted mb-4">Sistema de gestión de pacientes y consultas médicas veterinarias.</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('mascotas.index') }}" class="btn btn-primary btn-lg">Ver Mascotas</a>
        <a href="{{ route('consultas.index') }}" class="btn btn-outline-primary btn-lg">Ver Consultas</a>
    </div>
</div>
@endsection
