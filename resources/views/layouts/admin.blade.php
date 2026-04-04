<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Balcão Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #0a3d62; --accent: #e67e22; }
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: var(--primary) !important; }
        .navbar .nav-link, .navbar-brand { color: #fff !important; }
        .sidebar { background: var(--primary); min-height: calc(100vh - 56px); width: 230px; position: fixed; top: 56px; left: 0; overflow-y: auto; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); padding: .6rem 1.2rem; border-radius: 6px; margin: 2px 8px; display: flex; align-items: center; gap: 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: var(--accent); color: #fff; }
        .main-content { margin-left: 230px; padding: 2rem; }
        .card { border: none; box-shadow: 0 1px 6px rgba(0,0,0,.08); border-radius: 10px; }
        .table thead th { background: var(--primary); color: #fff; border: none; }
        .badge-valid    { background: #27ae60 !important; }
        .badge-expired  { background: #e67e22 !important; }
        .badge-cancelled{ background: #c0392b !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="/admin/permits">
            <i class="bi bi-building-check me-2"></i>Balcão Virtual · Admin
        </a>
    </div>
</nav>

<div class="sidebar pt-3">
    <nav class="nav flex-column">
        <span class="text-white-50 px-3 py-2 small text-uppercase fw-semibold">Documentos</span>
        <a href="{{ route('admin.permits.index') }}"
           class="nav-link {{ request()->routeIs('admin.permits.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Licenças/Permisos
        </a>
        <span class="text-white-50 px-3 py-2 mt-3 small text-uppercase fw-semibold">Sistema</span>
        <a href="{{ route('validation.validate', ['_token' => csrf_token(), 'document_type' => 'Permit', 'number' => '19000']) }}"
           class="nav-link" target="_blank">
            <i class="bi bi-qr-code-scan"></i> Testar Validação
        </a>
    </nav>
</div>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
