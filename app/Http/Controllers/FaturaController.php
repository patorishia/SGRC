<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FaturaController extends Controller
{
    // Exibe a lista de faturas
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); // Redireciona para a página de acesso não autorizado
        }
        return view('faturas.index');
    }

    // Edita uma fatura existente
    public function edit($id)
    {
        // Define a URL base da API
        $apiUrl = "https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2";

        // Obtém os dados da fatura a partir da API
        $response = Http::get("{$apiUrl}/invoices/{$id}");

        if ($response->successful()) {
            // Processa a resposta JSON
            $fatura = $response->json();
            return view('faturas.edit', compact('fatura'));
        } else {
            // Em caso de erro, redireciona para a página de faturas com uma mensagem de erro
            return redirect()->route('faturas.index')->with('error', 'Fatura não encontrada.');
        }
    }

    // Exibe as faturas do utilizador autenticado
    public function minhasFaturas()
    {
        // Obtém o utilizador autenticado
        $user = Auth::user();
        
        // Obtém o NIF do utilizador 
        $userNif = $user->nif;

        // Passa o NIF para a vista
        return view('faturas.user.index', compact('userNif'));
    }

    // Método para criar uma nova fatura
    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized');
        }
        $userNifs = User::pluck('nif')->toArray();

        return view('faturas.create', compact('userNifs'));
    }

    

    // Exibe uma fatura específica
    public function show($id)
    {
        // Passa o id para a vista
        return view('faturas.show', compact('id'));
    }

    // Método para exibir o formulário da fatura com base no NIF do utilizador autenticado
    public function showInvoiceForm()
    {
        // Obtém o NIF do utilizador autenticado
        $userNif = auth()->user()->nif;

        // Obtém a lista de clientes onde o NIF coincide com o do utilizador autenticado
        $clients = User::where('nif', $userNif)->get();

        return view('faturas.create', compact('clients'));
    }
}
