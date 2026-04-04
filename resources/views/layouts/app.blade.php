<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Balcão Virtual') — MTC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0a3d62;
            --accent:  #e67e22;
        }
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .navbar-brand img { height: 40px; }
        .navbar { background: var(--primary) !important; }
        .navbar .nav-link, .navbar-brand { color: #fff !important; }
        .sidebar { background: var(--primary); min-height: calc(100vh - 56px); }
        .sidebar .nav-link { color: rgba(255,255,255,.75); padding: .6rem 1.2rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: var(--accent); color: #fff; }
        .sidebar .nav-link i { width: 20px; }
        .card { border: none; box-shadow: 0 1px 6px rgba(0,0,0,.08); border-radius: 10px; }
        .badge-valid   { background: #27ae60; }
        .badge-expired { background: #e67e22; }
        .badge-cancelled { background: #c0392b; }
        .status-bar { border-left: 5px solid; padding: 1rem 1.5rem; border-radius: 8px; }
        .status-bar.valid    { border-color: #27ae60; background: #eafaf1; }
        .status-bar.expired  { border-color: #e67e22; background: #fef9e7; }
        .status-bar.cancelled{ border-color: #c0392b; background: #fdedec; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-building-check me-2"></i>Balcão Virtual · MTC
        </a>
    </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
