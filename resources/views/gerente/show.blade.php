@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes do Condómino') }}: {{ $condomino->nome }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Título do Condomínio -->
                <h3 class="text-dark mb-4">{{ __('Detalhes do Condómino') }}: <span class="text-primary">{{ $condomino->nome }}</span></h3>
                
                <!-- Tabela com os detalhes do Condomínio -->
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
                                <td><strong>{{ __('Nome') }}</strong></td>
                                <td>{{ $condomino->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Email') }}</strong></td>
                                <td>{{ $condomino->email }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Telefone') }}</strong></td>
                                <td>{{ $condomino->telefone }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Condomínio') }}</strong></td>
                                <td>{{ optional($condomino->condominio)->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Criação') }}</strong></td>
                                <td>{{ $condomino->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Atualização') }}</strong></td>
                                <td>{{ $condomino->updated_at->format('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

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

                <!-- Botões de ações para admin -->
                @if(auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <a href="{{ route('condominos.edit', $condomino->nif) }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Formulário para excluir o condomínio -->
                        <form action="{{ route('condominos.destroy', $condomino->nif) }}" method="POST" class="inline-block mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Tem certeza que deseja apagar este condomínio?')">
                                <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                            </button>
                        </form>
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
