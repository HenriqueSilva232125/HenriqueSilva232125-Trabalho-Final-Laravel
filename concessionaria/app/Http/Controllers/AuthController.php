<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validação simples
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        // Guarda o nome do usuário na sessão
        session(['usuario' => $request->nome]);

        return redirect()->route('veiculos.index')
            ->with('success', 'Login realizado com sucesso!');
    }

    public function logout()
    {
        session()->forget('usuario');

        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }
}

