<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\Condominio;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalCondominios = Condominio::count();

        // Contando as reclamações
        $totalReclamacoes = Reclamacao::count();
        
        // Obtendo as últimas reclamações (supondo que você tenha essas colunas na tabela)
        $ultimasReclamacoes = Reclamacao::orderBy('created_at', 'desc')->take(5)->get();

        // Retornando a view com as variáveis necessárias
        return view('dashboard', compact('totalReclamacoes', 'ultimasReclamacoes', 'totalCondominios'));
    }
}
