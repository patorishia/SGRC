@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="text-dark mb-4">{{ __('Detalhes do Tipo de Reclamação') }}: <span class="text-primary">{{ $tiposReclamacao->tipo }}</span></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Tabela com os detalhes do Tipo de Reclamação em estilo similar ao index -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-gray text-white">
                                <tr>
                                    <th class="text-center text-shadow">{{ __('Campo') }}</th>
                                    <th class="text-center text-shadow">{{ __('Valor') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>{{ __('Tipo') }}</strong></td>
                                    <td>{{ $tiposReclamacao->tipo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Descrição') }}</strong></td>
                                    <td>{{ $tiposReclamacao->descricao }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Criação') }}</strong></td>
                                    <td>{{ $tiposReclamacao->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Atualização') }}</strong></td>
                                    <td>{{ $tiposReclamacao->updated_at->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Botões de ações para admin dentro do card -->
                    @if(auth()->user()->role === 'admin')
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('tipos_reclamacao.edit', $tiposReclamacao->id) }}" class="btn btn-warning btn-lg mx-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <!-- Botão para acionar o modal de exclusão -->
                            <button type="button" class="btn btn-danger btn-lg mx-2" data-toggle="modal" data-target="#confirmDeleteModal">
                                <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal de confirmação de exclusão -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">{{ __('Confirmar Exclusão') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('Tem certeza de que deseja apagar este tipo de reclamação? Esta ação não pode ser desfeita.') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                            <form action="{{ route('tipos_reclamacao.destroy', $tiposReclamacao->id) }}" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('Apagar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
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

@push('styles')
    <style>
        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .btn-lg {
            padding: 12px 30px;
            font-size: 18px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
