@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes do Condomínio') }}: {{ $condominio->nome }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Título do Condomínio -->
                <h3 class="text-dark mb-4">{{ __('Detalhes do Condomínio') }}: <span class="text-primary">{{ $condominio->nome }}</span></h3>

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
                                <td>{{ $condominio->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Endereço') }}</strong></td>
                                <td>{{ $condominio->endereco }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Cidade') }}</strong></td>
                                <td>{{ $condominio->cidade }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Código Postal') }}</strong></td>
                                <td>{{ $condominio->codigo_postal }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Criação') }}</strong></td>
                                <td>{{ $condominio->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Atualização') }}</strong></td>
                                <td>{{ $condominio->updated_at->format('d/m/Y') }}</td>
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
                        <a href="{{ route('condominios.edit', $condominio->id) }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Formulário para excluir o condomínio -->
                        <form action="{{ route('condominios.destroy', $condominio->id) }}" method="POST" class="inline-block mt-2">
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

