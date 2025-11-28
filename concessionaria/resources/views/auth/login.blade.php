@extends('layouts.app')

@section('content')
<h1>Login</h1>

<form action="{{ route('login.post') }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">Seu nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Entrar</button>
</form>
@endsection
