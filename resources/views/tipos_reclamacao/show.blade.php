@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes do Tipo de Reclamação') }}: {{ $tiposReclamacao->tipo }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Título do Tipo de Reclamação -->
                <h3 class="text-dark mb-4">{{ __('Detalhes do Tipo de Reclamação') }}: <span class="text-primary">{{ $tiposReclamacao->tipo }}</span></h3>

                <!-- Tabela com os detalhes do Tipo de Reclamação -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">{{ __('Campo') }}</th>
                                <th class="text-center">{{ __('Valor') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td><strong>{{ __('Tipo') }}</strong></td>
                                <td>{{ $tiposReclamacao->tipo }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Descrição') }}</strong></td>
                                <td>{{ $tiposReclamacao->descricao }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Criação') }}</strong></td>
                                <td>{{ $tiposReclamacao->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Atualização') }}</strong></td>
                                <td>{{ $tiposReclamacao->updated_at->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Botões de ações para admin -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <a href="{{ route('tipos_reclamacao.edit', $tiposReclamacao->id) }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit"></i> {{__('Editar')}}
                        </a>

                        <!-- Formulário para excluir o tipo de reclamação -->
                        <form action="{{ route('tipos_reclamacao.destroy', $tiposReclamacao->id) }}" method="POST" class="inline-block mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Tem certeza que deseja apagar este tipo de reclamação?')">
                                <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Exibir a notificação de erro ou sucesso -->
                @if(session('error'))
                    <div id="error-message" class="alert alert-danger mt-4 rounded">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @elseif(session('success'))
                    <div id="success-message" class="alert alert-success mt-4 rounded">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Função para esconder as mensagens de erro ou sucesso após um tempo
        window.onload = function() {
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');

            // Se houver uma mensagem de erro, esconde após 5 segundos
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.opacity = 0;
                    setTimeout(function() {
                        errorMessage.style.display = 'none';
                    }, 500); // Atraso para permitir a animação
                }, 5000);
            }

            // Se houver uma mensagem de sucesso, esconde após 5 segundos
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.opacity = 0;
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                    }, 500); // Atraso para permitir a animação
                }, 5000);
            }
        }
    </script>
@endsection
