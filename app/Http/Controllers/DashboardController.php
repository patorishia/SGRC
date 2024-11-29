<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\Condominio;
use App\Models\TiposReclamacao;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalCondominios = Condominio::count();
        $totalReclamacoes = Reclamacao::count();
        $ultimasReclamacoes = Reclamacao::orderBy('created_at', 'desc')->take(5)->get();
        $reclamacoesResolvidas = Reclamacao::where('estado', 'resolvida')->count();
        // Procura apenas as reclamações com o estado "pendente"
        $reclamacoesPendentes = Reclamacao::with('tipoReclamacao', 'condominio', 'condomino', 'estado')
            ->where('estado', 1) // Filtra para mostrar apenas as pendentes
            ->get();

        $tiposLabels = TiposReclamacao::pluck('tipo')->toArray();
        $tiposValues = TiposReclamacao::withCount('reclamacoes')->get()->pluck('reclamacoes_count')->toArray();


        // Obter número de reclamações por mês
        $reclamacoesPorMes = Reclamacao::selectRaw("COUNT(*) as count, MONTHNAME(created_at) as month")
            ->groupBy('month')
            ->orderByRaw("MONTH(created_at)")
            ->get();

        // Extrair labels e valores para o gráfico
        $labels = $reclamacoesPorMes->pluck('month');
        $values = $reclamacoesPorMes->pluck('count');

        // Passar dados para a view
        return view('dashboard', compact('totalReclamacoes', 'ultimasReclamacoes', 'totalCondominios', 'labels', 'values', 'tiposLabels', 'tiposValues', 'reclamacoesPendentes'));

        return view('dashboard', compact(
            'totalCondominios',
            'totalReclamacoes',
            'reclamacoesPendentes',
            'reclamacoesResolvidas',
            'ultimasReclamacoes'
        ));
    }
}