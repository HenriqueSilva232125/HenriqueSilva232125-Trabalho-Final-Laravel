<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session()->has('usuario')) {
                return redirect()->route('login')
                    ->with('error', 'Você precisa estar logado.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Veiculo::with('marca');

        $marcaCookie = $request->cookie('ultima_marca');
        if ($marcaCookie) {
            $query->where('marca_id', $marcaCookie);
        }

        $veiculos = $query->paginate(10);
        $marcas   = Marca::all();

        return view('veiculos.index', compact('veiculos', 'marcas', 'marcaCookie'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('veiculos.create', compact('marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo'   => 'required|string|max:100',
            'ano'      => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'preco'    => 'required|numeric|min:0',
            'marca_id' => 'required|exists:marcas,id',
            'foto'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $dados = $request->only(['modelo', 'ano', 'preco', 'marca_id']);

        if ($request->hasFile('foto')) {
            $caminho = $request->file('foto')->store('veiculos', 'public');
            $dados['foto'] = $caminho;
        }

        $veiculo = Veiculo::create($dados);

        // Salva cookie com a última marca utilizada
        cookie()->queue('ultima_marca', $veiculo->marca_id, 60 * 24 * 7); // 7 dias

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit(Veiculo $veiculo)
    {
        $marcas = Marca::all();
        return view('veiculos.edit', compact('veiculo', 'marcas'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $request->validate([
            'modelo'   => 'required|string|max:100',
            'ano'      => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'preco'    => 'required|numeric|min:0',
            'marca_id' => 'required|exists:marcas,id',
            'foto'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $dados = $request->only(['modelo', 'ano', 'preco', 'marca_id']);

        if ($request->hasFile('foto')) {
            // Apaga foto antiga se existir
            if ($veiculo->foto && Storage::disk('public')->exists($veiculo->foto)) {
                Storage::disk('public')->delete($veiculo->foto);
            }

            $caminho = $request->file('foto')->store('veiculos', 'public');
            $dados['foto'] = $caminho;
        }

        $veiculo->update($dados);

        cookie()->queue('ultima_marca', $veiculo->marca_id, 60 * 24 * 7);

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy(Veiculo $veiculo)
    {
        if ($veiculo->foto && Storage::disk('public')->exists($veiculo->foto)) {
            Storage::disk('public')->delete($veiculo->foto);
        }

        $veiculo->delete();

        return redirect()->route('veiculos.index')
            ->with('success', 'Veículo excluído com sucesso!');
    }
}
