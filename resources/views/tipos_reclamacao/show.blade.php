@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes do Tipo de Reclamação') }}: {{ $tiposReclamacao->tipo }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ __('Detalhes do Tipo de Reclamação') }}: {{ $tiposReclamacao->tipo }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-bold">Tipo: {{ $tiposReclamacao->tipo }}</p>
                        <p>Descrição: {{ $tiposReclamacao->descricao }}</p>
                        <p>Data de Criação: {{ $tiposReclamacao->created_at->format('d/m/Y') }}</p>
                        <p>Data de Atualização: {{ $tiposReclamacao->updated_at->format('d/m/Y') }}</p>

                        <!-- Verifica se o usuário é admin -->
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('tipos_reclamacao.edit', $tiposReclamacao->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- Formulário para excluir o tipo de reclamação -->
                            <form action="{{ route('tipos_reclamacao.destroy', $tiposReclamacao->id) }}" method="POST" class="inline-block mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar este tipo de reclamação?')">
                                    <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                                </button>
                            </form>
                        @endif

                        <!-- Exibir a notificação de erro ou sucesso -->
                        @if(session('error'))
                            <div id="error-message" class="alert alert-danger mt-4">
                                {{ session('error') }}
                            </div>
                        @elseif(session('success'))
                            <div id="success-message" class="alert alert-success mt-4">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para esconder as mensagens de erro ou sucesso após um tempo
        window.onload = function() {
            // Verifica se existe a mensagem de erro
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
