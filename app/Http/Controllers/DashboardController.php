<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\Condominio;
use ConsoleTVs\Charts\Facades\Charts;

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

        // Exemplo de dados para o gráfico
        $reclamacoesPorMes = Reclamacao::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->get();

        // Criar gráfico de barras
        $chart = Charts::create('bar', 'chartjs')
            ->title('Volume de Reclamações por Mês')
            ->labels($reclamacoesPorMes->pluck('mes'))
            ->values($reclamacoesPorMes->pluck('total'))
            ->dimensions(1000, 500)
            ->responsive(true);


        // Retornando a view com as variáveis necessárias
        return view('dashboard', compact('totalReclamacoes', 'ultimasReclamacoes', 'totalCondominios', 'chart'));
    }
}
