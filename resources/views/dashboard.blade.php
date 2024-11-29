@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Estatísticas -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalCondominios }}</h3>
                        <p>Total de Condomínios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('condominios.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalReclamacoes }}</h3>
                        <p>Total de Reclamações</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('reclamacoes.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gráfico de Reclamações</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="reclamacoesChart" style="max-height: 200px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Distribuição por Tipo</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="tipoReclamacaoChart" style="max-height: 200px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Evolução no Tempo</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="evolucaoReclamacoesChart" style="max-height: 200px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comparação entre Tipos</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="radarReclamacaoChart" style="max-height: 200px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabelas -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Últimas Reclamações</h3>
                    </div>
                    <div class="card-body">
                        <table id="ultimasReclamacoesTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Condómino</th>
                                    <th>Condomínio</th>
                                    <th>Descrição</th>
                                    <th>Data de Criação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimasReclamacoes as $reclamacao)
                                    <tr>
                                        <td>{{ $reclamacao->condomino->nome }}</td>
                                        <td>{{ $reclamacao->condominio->nome }}</td>
                                        <td>{{ $reclamacao->descricao }}</td>
                                        <td>{{ $reclamacao->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reclamações Pendentes</h3>
                    </div>
                    <div class="card-body">
                        <table id="reclamacoesPendentesTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Condómino</th>
                                    <th>Condomínio</th>
                                    <th>Descrição</th>
                                    <th>Data de Criação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reclamacoesPendentes as $reclamacao)
                                    <tr>
                                        <td>{{ $reclamacao->condomino->nome }}</td>
                                        <td>{{ $reclamacao->condominio->nome }}</td>
                                        <td>{{ $reclamacao->descricao }}</td>
                                        <td>{{ $reclamacao->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Inicialização dos gráficos
    const ctx = document.getElementById('reclamacoesChart').getContext('2d');
    const reclamacoesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Reclamações por Mês',
                data: {!! json_encode($values) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxPizza = document.getElementById('tipoReclamacaoChart').getContext('2d');
    const tipoReclamacaoChart = new Chart(ctxPizza, {
        type: 'pie',
        data: {
            labels: {!! json_encode($tiposLabels) !!},
            datasets: [{
                label: 'Distribuição de Reclamações por Tipo',
                data: {!! json_encode($tiposValues) !!},
                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#9e89ff'],
                borderColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    const ctxLinha = document.getElementById('evolucaoReclamacoesChart').getContext('2d');
    const evolucaoReclamacoesChart = new Chart(ctxLinha, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Reclamações por Mês',
                data: {!! json_encode($values) !!},
                borderColor: '#34d399',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxRadar = document.getElementById('radarReclamacaoChart').getContext('2d');
    const radarReclamacaoChart = new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: {!! json_encode($tiposLabels) !!},
            datasets: [{
                label: 'Tipos de Reclamações',
                data: {!! json_encode($tiposValues) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {}
        }
    });

    // Inicialização do DataTables
    $(document).ready(function() {
        $('#ultimasReclamacoesTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
        });

        $('#reclamacoesPendentesTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
        });
    });
</script>

@endsection
