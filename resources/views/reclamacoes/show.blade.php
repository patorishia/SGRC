@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes da Reclamação') }}: {{ $reclamacao->descricao }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ __('Detalhes da Reclamação') }}: {{ $reclamacao->descricao }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-bold">Descrição: {{ $reclamacao->descricao }}</p>
                        <p><strong>Condomínio:</strong> {{ optional($reclamacao->condominio)->nome }}</p>
                        <p><strong>Condomino:</strong> {{ optional($reclamacao->condomino)->nome }}</p>
                        <p><strong>Tipo de Reclamação:</strong> {{ optional($reclamacao->tipoReclamacao)->tipo }}</p>
                        <p><strong>Estado:</strong> {{ optional($reclamacao->Estado)->nome }}</p>
                        <p><strong>Data de Criação:</strong> {{ $reclamacao->created_at->format('d/m/Y') }}</p>
                        <p><strong>Data de Resolução:</strong> {{ $reclamacao->data_resolucao ? $reclamacao->data_resolucao->format('d/m/Y') : 'Não resolvida' }}</p>

                        <!-- Verificar se existem anexos -->
                        @if($reclamacao->anexos)
                            <div class="mb-4">
                                <label class="font-weight-bold">Anexos Atuais:</label>
                                <div class="row">
                                    @foreach(json_decode($reclamacao->anexos) as $anexo)
                                        @php
                                            $filePath = public_path('storage/' . $anexo);
                                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        @endphp

                                        <div class="col-md-3">
                                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <!-- Exibir imagem -->
                                                <img src="{{ asset('storage/' . $anexo) }}" alt="Anexo" class="img-thumbnail">
                                            @else
                                                <!-- Exibir ícone de download -->
                                                <a href="{{ asset('storage/' . $anexo) }}" class="btn btn-primary btn-block" download>
                                                    <i class="fas fa-download"></i> {{ pathinfo($anexo, PATHINFO_BASENAME) }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- Formulário para excluir a reclamação -->
                            <form action="{{ route('reclamacoes.destroy', $reclamacao->id) }}" method="POST" class="inline-block mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar esta reclamação?')">
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
