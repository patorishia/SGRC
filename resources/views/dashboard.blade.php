<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total de Condomínios -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Total de Condomínios</h3>
                        <p class="text-2xl">{{ $totalCondominios }}</p>
                        <a href="{{ route('condominios.index') }}" class="text-blue-500">Ver todas os Condomínios</a>
                    </div>
                </div>

                <!-- Total de Reclamações -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Total de Reclamações</h3>
                        <p class="text-2xl">{{ $totalReclamacoes }}</p>
                        <a href="{{ route('reclamacoes.index') }}" class="text-blue-500">Ver todas as reclamações</a>
                    </div>
                </div>

                <!-- Acesso a Gráficos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Estatísticas</h3>
                        <p class="text-2xl">Gráficos</p>
                        <a href="#reclamacoesChart" class="text-blue-500">Ver gráficos</a>
                    </div>
                </div>
            </div>

            <!-- Gráficos Interativos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Gráficos de Reclamações</h3>
                    <canvas id="reclamacoesChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Gráfico de Pizza - Distribuição de Reclamações por Tipo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Distribuição de Reclamações por Tipo</h3>
                    <canvas id="tipoReclamacaoChart" width="400" height="200"></canvas>
                </div>
            </div>
            <!-- Gráfico de Linha - Evolução das Reclamações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Evolução das Reclamações ao Longo do Tempo</h3>
                    <canvas id="evolucaoReclamacoesChart" width="400" height="200"></canvas>
                </div>
            </div>


            <!-- Gráfico de Radar - Comparação entre Tipos de Reclamação -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Comparação entre Tipos de Reclamação</h3>
                    <canvas id="radarReclamacaoChart" width="400" height="200"></canvas>
                </div>
            </div>


            <!-- Últimas Reclamações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Últimas Reclamações</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>Condómino</th>
                                <th>Condomínio</th>
                                <th>Descrição</th>
                                <th>Data de Criação</th>
                                <th>Última Atualização</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ultimasReclamacoes as $reclamacao)
                                <tr>
                                    <td>{{ $reclamacao->condomino->nome }}</td>
                                    <td>{{ $reclamacao->condominio->nome }}</td>
                                    <td>{{ $reclamacao->descricao }}</td>
                                    <td>{{ $reclamacao->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $reclamacao->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!--  Reclamações Pendentes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Reclamações Pendentes</h3>
                    <table class="min-w-full mt-4">
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


</x-app-layout>



<!-- Scripts para Gráficos (exemplo usando Chart.js) -->

<!--Gráfico Bar-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reclamacoesChart').getContext('2d');
    const reclamacoesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!}, // Labels dos meses
            datasets: [{
                label: 'Reclamações por Mês',
                data: {!! json_encode($values) !!}, // Valores das reclamações
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
</script>
<!--Gráfico Pizza-->
<script>
    const ctxPizza = document.getElementById('tipoReclamacaoChart').getContext('2d');
    const tipoReclamacaoChart = new Chart(ctxPizza, {
        type: 'pie', // Tipo de gráfico: Pizza
        data: {
            labels: {!! json_encode($tiposLabels) !!}, // Tipos de reclamação
            datasets: [{
                label: 'Distribuição de Reclamações por Tipo',
                data: {!! json_encode($tiposValues) !!}, // Valores das reclamações por tipo
                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#9e89ff'], // Cores de cada segmento
                borderColor: 'rgba(0, 0, 0, 0.1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' Reclamações';
                        }
                    }
                }
            }
        }
    });
</script>


<!--Gráfico Linha-->
<script>
    const ctxLinha = document.getElementById('evolucaoReclamacoesChart').getContext('2d');
    const evolucaoReclamacoesChart = new Chart(ctxLinha, {
        type: 'line', // Tipo de gráfico: Linha
        data: {
            labels: {!! json_encode($labels) !!}, // Meses ou datas passadas do controlador
            datasets: [{
                label: 'Reclamações por Mês',
                data: {!! json_encode($values) !!}, // Valores das reclamações por mês
                borderColor: '#34d399', // Cor da linha
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor do fundo da linha
                fill: true, // Preenchimento da área abaixo da linha
                tension: 0.3 // Suavização da linha
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
</script>


<!--Gráfico Radar-->
<script>
    const ctxRadar = document.getElementById('radarReclamacaoChart').getContext('2d');
    const radarReclamacaoChart = new Chart(ctxRadar, {
        type: 'radar', // Tipo de gráfico: Radar
        data: {
            labels: {!! json_encode($tiposLabels) !!}, // Tipos de reclamação
            datasets: [{
                label: 'Comparação entre Tipos',
                data: {!! json_encode($tiposValues) !!}, // Valores para cada tipo de reclamação
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor do fundo
                borderColor: '#34d399', // Cor da borda
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });
</script>