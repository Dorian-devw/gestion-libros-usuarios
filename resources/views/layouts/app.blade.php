<!DOCTYPE html>
<html>
<head>
    <title>Sistema Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('libros.index') }}">Biblioteca</a>
            @if(session()->has('usuario'))
            <div>
                <span class="me-3">Bienvenido, {{ session('usuario')['nombre'] }}</span>
                <a href="{{ route('auth.logout') }}" class="btn btn-outline-danger">Salir</a>
            </div>
            @else
            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary">Login</a>
            @endif
        </div>
    </nav>
    
    <div class="container mt-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>