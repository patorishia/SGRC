@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes do Condomino') }}: {{ $condomino->nome }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ __('Detalhes do Condomino') }}: {{ $condomino->nome }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> {{ $condomino->nome }}</p>
                        <p><strong>Email:</strong> {{ $condomino->email }}</p>
                        <p><strong>Telefone:</strong> {{ $condomino->telefone }}</p>
                        <p><strong>Condomínio:</strong> {{ optional($condomino->condominio)->nome }}</p> <!-- Assumindo que você tenha uma relação definida -->
                        <p><strong>Data de Criação:</strong> {{ $condomino->created_at->format('d/m/Y') }}</p>
                        <p><strong>Data de Atualização:</strong> {{ $condomino->updated_at->format('d/m/Y') }}</p>

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

                        @if(auth()->user()->role === 'admin')
                            <div class="mt-4">
                                <a href="{{ route('condominos.edit', $condomino->nif) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Formulário para excluir o condomíno -->
                                <form action="{{ route('condominos.destroy', $condomino->nif) }}" method="POST" class="inline-block mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar este condomíno?')">
                                        <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                                    </button>
                                </form>
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
