@extends('layouts.app')

@section('content')
<h1>Novo Veículo</h1>

<form action="{{ route('veiculos.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf

    <div class="mb-3">
        <label class="form-label">Modelo</label>
        <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Ano</label>
        <input type="number" name="ano" class="form-control" value="{{ old('ano') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Preço</label>
        <input type="number" step="0.01" name="preco" class="form-control" value="{{ old('preco') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Marca</label>
        <select name="marca_id" class="form-select" required>
            <option value="">Selecione</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" @if(old('marca_id') == $marca->id) selected @endif>
                    {{ $marca->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Foto (PNG/JPG)</label>
        <input type="file" name="foto" class="form-control" accept=".png,.jpg,.jpeg">
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
