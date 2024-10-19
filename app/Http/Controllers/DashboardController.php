<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamacao;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Contando as reclamações
        $totalReclamacoes = Reclamacao::count();
        $reclamacoesPendentes = Reclamacao::where('estado', 'pendente')->count();
        $reclamacoesResolvidas = Reclamacao::where('estado', 'resolvida')->count();
        
        // Obtendo as últimas reclamações (supondo que você tenha essas colunas na tabela)
        $ultimasReclamacoes = Reclamacao::orderBy('data_criacao', 'desc')->take(5)->get();

        // Retornando a view com as variáveis necessárias
        return view('dashboard', compact('totalReclamacoes', 'reclamacoesPendentes', 'reclamacoesResolvidas', 'ultimasReclamacoes'));
    }
}
