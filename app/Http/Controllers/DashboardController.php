<?php

namespace App\Http\Controllers;

use App\Models\Condominio;
use App\Models\Reclamacao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCondominios = Condominio::count();
        $totalReclamacoes = Reclamacao::count();
        $reclamacoesPendentes = Reclamacao::where('estado', 'pendente')->count();
        $reclamacoesResolvidas = Reclamacao::where('estado', 'resolvida')->count();
        
        // Consultando as últimas reclamações
        $ultimasReclamacoes = Reclamacao::orderBy('data_criacao', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalCondominios',
            'totalReclamacoes',
            'reclamacoesPendentes',
            'reclamacoesResolvidas',
            'ultimasReclamacoes'
        ));
    }
}
