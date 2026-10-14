<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Física Pro - ITCA FEPADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0f19; color: #e2e8f0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background-color: #161e2e; border-bottom: 2px solid #00b4d8; }
        .card-custom { background-color: #161e2e; border: 1px solid #2d3748; border-radius: 10px; }
        .form-control, .form-select { background-color: #0d131f; border: 1px solid #2d3748; color: #fff; }
        .form-control:focus, .form-select:focus { background-color: #131a29; color: #fff; border-color: #00b4d8; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 mb-4">
        <a class="navbar-brand text-info fw-bold" href="/">🔬 SISTEMA WEB DE FÍSICA</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link btn btn-outline-info text-white mx-2 px-3" href="/simulador-vectores">📐 Simulador de Vectores</a>
            <a class="nav-link btn btn-outline-warning text-white mx-2 px-3" href="/conversor-unidades">🔄 Conversor de Unidades Gráfico</a>
            <a class="nav-link btn btn-outline-success text-white mx-2 px-3" href="/actividades">🎮 Actividades Interactivas</a>
        </div>
    </nav>

    <div class="container-fluid px-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>