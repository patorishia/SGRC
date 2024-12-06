@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Detalhes da Reclamação') }}: {{ $reclamacao->descricao }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Título da Reclamação -->
                <h3 class="text-dark mb-4">{{ __('Detalhes da Reclamação') }}: <span class="text-primary">{{ $reclamacao->descricao }}</span></h3>

                <!-- Tabela com os detalhes da Reclamação -->
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
                                <td><strong>{{ __('Descrição') }}</strong></td>
                                <td>{{ $reclamacao->descricao }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Condomínio') }}</strong></td>
                                <td>{{ optional($reclamacao->condominio)->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Condómino') }}</strong></td>
                                <td>{{ optional($reclamacao->condomino)->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Tipo de Reclamação') }}</strong></td>
                                <td>{{ optional($reclamacao->tipoReclamacao)->tipo }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Estado') }}</strong></td>
                                <td>{{ optional($reclamacao->estado)->nome }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Criação') }}</strong></td>
                                <td>{{ $reclamacao->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>{{ __('Data de Resolução') }}</strong></td>
                                <td>{{ $reclamacao->data_resolucao ? $reclamacao->data_resolucao->format('d/m/Y') : __('Não resolvida') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Verificar se existem anexos -->
                @if($reclamacao->anexos)
                    <div class="mb-4">
                        <label class="font-weight-bold">{{ __('Anexos Atuais:') }}</label>
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

                <!-- Botões de ações para admin -->
                @if(auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit"></i> {{ __('Editar') }}
                        </a>

                        <!-- Formulário para excluir a reclamação -->
                        <form action="{{ route('reclamacoes.destroy', $reclamacao->id) }}" method="POST" class="inline-block mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('{{ __('Tem certeza que deseja apagar esta reclamação?') }}')">
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
