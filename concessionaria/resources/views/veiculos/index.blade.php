@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Veículos</h1>
    <a href="{{ route('veiculos.create') }}" class="btn btn-success">Novo veículo</a>
</div>

<form method="GET" action="{{ route('veiculos.index') }}" class="row mb-3">
    <div class="col-md-4">
        <label for="marcaFiltro" class="form-label">Filtrar por marca</label>
        <select name="marca_id" id="marcaFiltro" class="form-select"
                onchange="this.form.submit()">
            <option value="">Todas</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}"
                    @if($marcaCookie == $marca->id) selected @endif>
                    {{ $marca->nome }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Preço</th>
            <th>Marca</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($veiculos as $veiculo)
            <tr>
                <td>{{ $veiculo->id }}</td>
                <td>
                    @if($veiculo->foto)
                        <img src="{{ asset('storage/' . $veiculo->foto) }}" alt="Foto" width="80">
                    @endif
                </td>
                <td>{{ $veiculo->modelo }}</td>
                <td>{{ $veiculo->ano }}</td>
                <td>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</td>
                <td>{{ $veiculo->marca->nome }}</td>
                <td>
                    <a href="{{ route('veiculos.edit', $veiculo) }}" class="btn btn-sm btn-primary">Editar</a>
                    <form action="{{ route('veiculos.destroy', $veiculo) }}" method="POST"
                          style="display:inline-block"
                          onsubmit="return confirm('Deseja excluir este veículo?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Nenhum veículo cadastrado.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $veiculos->links() }}
@endsection
