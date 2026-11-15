<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión') - Veterinaria Chacabuco</title>
    
    <!-- Tipografía Editorial / Humanista: Lora (serif para títulos y marca) + Source Sans 3 (cuerpo, tablas y controles) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,400&family=Source+Sans+3:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --font-heading: 'Lora', Georgia, 'Times New Roman', serif;
            --font-body: 'Source Sans 3', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;

            --bs-font-sans-serif: var(--font-body);
            --bs-body-font-family: var(--font-body);
            --bs-body-color: #272d2a;
            --bs-body-bg: #f7f6f2; /* Marfil / lino cálido tipo dossier */

            /* Paleta tradicional de clínica: Verde británico / Bosque profundo */
            --brand-primary: #194a3e;
            --brand-primary-hover: #12372e;
            --brand-primary-wash: #ebf2ee;
            --brand-dark: #11221d;
            --brand-border: #e3ded4;
            --brand-muted: #646f6a;

            --bs-primary: #194a3e;
            --bs-primary-rgb: 25, 74, 62;
            --bs-border-color: #e3ded4;
            --bs-border-radius: 0.375rem;
            --bs-border-radius-lg: 0.5rem;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            font-size: 0.95rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        main {
            flex: 1;
        }

        /* Navbar estilo sobrio / institucional */
        .app-navbar {
            background-color: var(--brand-dark) !important;
            border-bottom: 2px solid #1f3a33;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .navbar-brand {
            font-family: var(--font-heading);
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: #f7faf8 !important;
        }

        .brand-badge {
            background: #194a3e;
            color: #d1e5dd;
            font-family: var(--font-heading);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.05em;
            margin-right: 0.6rem;
            border: 1px solid rgba(209, 229, 221, 0.25);
        }

        .nav-link {
            font-family: var(--font-body);
            font-size: 0.92rem;
            font-weight: 500;
            color: #a4b8b2 !important;
            padding: 0.45rem 0.85rem !important;
            border-radius: 5px;
            transition: all 0.15s ease-in-out;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.12);
            font-weight: 600;
        }

        /* Títulos elegantes con serifa Lora */
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: var(--font-heading);
            font-weight: 600;
            letter-spacing: -0.015em;
            color: #14231f;
        }

        /* Botones refinados */
        .btn {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.885rem;
            padding: 0.42rem 0.95rem;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .btn-primary {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
            box-shadow: 0 1px 2px rgba(17, 34, 29, 0.15);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--brand-primary-hover) !important;
            border-color: var(--brand-primary-hover) !important;
            color: #ffffff !important;
        }

        .btn-outline-primary {
            border-color: var(--brand-primary);
            color: var(--brand-primary);
            background-color: #ffffff;
        }

        .btn-outline-primary:hover {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
        }

        .btn-outline-secondary {
            border-color: #d3ccc0;
            color: #454d49;
            background-color: #ffffff;
        }

        .btn-outline-secondary:hover {
            background-color: #ebe7de;
            border-color: #c4bbb0;
            color: #1c2220;
        }

        .btn-outline-info {
            border-color: #cfdbd6;
            color: #194a3e;
            background-color: #ffffff;
        }

        .btn-outline-info:hover {
            background-color: #eaf1ed;
            border-color: #b5c7c0;
            color: #11342c;
        }

        .btn-outline-warning {
            border-color: #ebd7be;
            color: #8c4a07;
            background-color: #ffffff;
        }

        .btn-outline-warning:hover {
            background-color: #fef4e8;
            border-color: #dec09a;
            color: #6a3400;
        }

        .btn-outline-danger {
            border-color: #fad1d1;
            color: #a82525;
            background-color: #ffffff;
        }

        .btn-outline-danger:hover {
            background-color: #fdf0f0;
            border-color: #f3aaaa;
            color: #831818;
        }

        .btn-warning {
            background-color: #bd6a15;
            border-color: #bd6a15;
            color: #ffffff;
        }

        .btn-warning:hover {
            background-color: #9e550e;
            border-color: #9e550e;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #b52a26;
            border-color: #b52a26;
        }

        .btn-danger:hover {
            background-color: #94201d;
            border-color: #94201d;
        }

        .btn-group-sm > .btn {
            padding: 0.35rem 0.55rem;
            font-size: 0.82rem;
        }

        /* Tarjetas estilo dossier clásico */
        .card {
            border: 1px solid var(--brand-border);
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(17, 34, 29, 0.03);
        }

        .card-header {
            font-family: var(--font-heading);
            background-color: #ffffff;
            border-bottom: 1px solid #ebe6dc;
            padding: 0.95rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #162420;
        }

        /* Tablas */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            --bs-table-hover-bg: #f9f8f5;
            font-size: 0.92rem;
            color: #242a28;
            margin-bottom: 0;
        }

        .table thead th {
            font-family: var(--font-body);
            background-color: #f2efe8;
            color: #555d59;
            font-size: 0.73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #dfd9ce;
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .table tbody td {
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #eeeae2;
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Inputs y Selects */
        .form-control, .form-select {
            border-color: #d5cfc4;
            border-radius: 6px;
            font-size: 0.92rem;
            padding: 0.5rem 0.8rem;
            color: #1f2725;
            background-color: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(25, 74, 62, 0.12);
        }

        .input-group-text {
            background-color: #f2efe8;
            border-color: #d5cfc4;
            color: #555d59;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.835rem;
            font-weight: 600;
            color: #3b4440;
            margin-bottom: 0.35rem;
        }

        /* Textos y Badges */
        .text-primary {
            color: var(--brand-primary) !important;
        }

        .text-success {
            color: #17634f !important;
        }

        .badge {
            font-family: var(--font-body);
            font-weight: 600;
            padding: 0.35em 0.65em;
            border-radius: 5px;
            letter-spacing: 0.01em;
        }

        .badge.bg-primary {
            background-color: var(--brand-primary-wash) !important;
            color: var(--brand-primary) !important;
            border: 1px solid rgba(25, 74, 62, 0.2);
        }

        .badge.bg-info {
            background-color: #ebf2ee !important;
            color: #194a3e !important;
            border: 1px solid #ceddd6 !important;
        }

        .badge.bg-secondary-subtle {
            background-color: #eeeae2 !important;
            color: #404743 !important;
            border: 1px solid #dcd6cb !important;
        }

        .badge.bg-light {
            background-color: #f2eee6 !important;
            color: #383e3b !important;
            border-color: #dfd8cd !important;
        }

        /* Alertas */
        .alert {
            border-radius: 7px;
            font-size: 0.92rem;
            border-width: 1px;
        }

        .alert-success {
            background-color: #ebf5f0;
            border-color: #c5dfd4;
            color: #14463a;
        }

        .alert-danger {
            background-color: #fdf3f3;
            border-color: #f6cfcf;
            color: #8c2424;
        }

        /* Paginador */
        .pagination .page-item .page-link {
            color: var(--brand-primary);
            border-color: #dbd5c9;
            font-size: 0.88rem;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
        }

        /* Footer */
        footer {
            background-color: #ffffff;
            border-top: 1px solid var(--brand-border);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('mascotas.index') }}">
                <span class="brand-badge">VC</span>
                <span>Veterinaria Chacabuco</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContenido">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mascotas.*') ? 'active' : '' }}" href="{{ route('mascotas.index') }}">
                            Mascotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}" href="{{ route('consultas.index') }}">
                            Consultas Médicas
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('mascotas.create') }}" class="btn btn-outline-light btn-sm">
                        + Nueva Mascota
                    </a>
                    <a href="{{ route('consultas.create') }}" class="btn btn-primary btn-sm" style="background-color: #235c4f; border-color: #235c4f;">
                        + Nueva Consulta
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-exclamation-octagon me-2 fs-5"></i>
                    <strong>Por favor corrija los siguientes errores:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-3 mt-auto">
        <div class="container text-center text-muted small">
            <span>Veterinaria Chacabuco &copy; {{ date('Y') }} &middot; Cortaberria & Cao &middot; Trabajo Integrador Laravel</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>