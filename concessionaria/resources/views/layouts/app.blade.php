@php
    $darkMode = request()->cookie('dark_mode', 'off') === 'on';
@endphp
<!DOCTYPE html>
<html lang="pt-BR" @if($darkMode) data-theme="dark" @endif>
<head>
    <meta charset="UTF-8">
    <title>Concessionária</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body[data-theme="dark"], [data-theme="dark"] body {
            background-color: #121212;
            color: #eee;
        }
        .navbar-dark-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body @if($darkMode) data-theme="dark" @endif>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('veiculos.index') }}">Concessionária</a>

        <div class="d-flex">
            <form method="POST" action="{{ url('/toggle-dark') }}" class="me-3">
                @csrf
                <button class="btn btn-sm btn-outline-secondary" type="submit">
                    {{ $darkMode ? 'Modo Claro' : 'Modo Escuro' }}
                </button>
            </form>

            @if(session('usuario'))
                <span class="me-2">Olá, {{ session('usuario') }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-danger" type="submit">Sair</button>
                </form>
            @endif
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Erros:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
