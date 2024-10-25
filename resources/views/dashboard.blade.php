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
                        <p class="text-2xl">{{ $totalCondominios}}</p>
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

                <!-- Reclamações Pendentes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Reclamações Pendentes</h3>
                        <p class="text-2xl">{{ $reclamacoesPendentes }}</p>
                        <a href="{{ route('reclamacoes.pendentes') }}" class="text-blue-500">Ver pendentes</a>
                    </div>
                </div>

                <!-- Reclamações Resolvidas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Reclamações Resolvidas</h3>
                        <p class="text-2xl">{{ $reclamacoesResolvidas }}</p>
                        <a href="{{ route('reclamacoes.resolvidas') }}" class="text-blue-500">Ver resolvidas</a>
                    </div>
                </div>

                <!-- Acesso a Gráficos -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Estatísticas</h3>
                        <p class="text-2xl">Gráficos</p>
                        <a  class="text-blue-500">Ver gráficos</a>
                    </div>
                </div>
            </div>

            <!-- Gráficos Interativos (Placeholder para gráficos dinâmicos) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Gráficos de Reclamações</h3>
                    <!-- Espaço para renderizar gráficos com bibliotecas como Chart.js ou outra de sua escolha -->
                    <div>
                        <canvas id="reclamacoesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Últimas Reclamações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Últimas Reclamações</h3>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Data de Criação</th>
                                <th>Última Atualização</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ultimasReclamacoes as $reclamacao)
                                <tr>
                                    <td>{{ $reclamacao->id }}</td>
                                    <td>{{ $reclamacao->descricao }}</td>
                                    <td>{{ $reclamacao->data_criacao->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('reclamacoes.show', $reclamacao->id) }}" class="text-blue-500">Ver</a>
                                        <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="ml-2 text-yellow-500">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para Gráficos (exemplo usando Chart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('reclamacoesChart').getContext('2d');
        const reclamacoesChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: ['Total', 'Pendentes', 'Resolvidas'], // Rótulos
                datasets: [{
                    label: 'Reclamações',
                    data: [{{ $totalReclamacoes }}, {{ $reclamacoesPendentes }}, {{ $reclamacoesResolvidas }}], // Dados
                    backgroundColor: ['#f87171', '#fbbf24', '#34d399'], // Cores
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
</x-app-layout>
