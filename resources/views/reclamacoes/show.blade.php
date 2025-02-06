@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="text-dark mb-4">{{ __('Detalhes da Reclamação') }}: <span
                        class="text-primary">{{ $reclamacao->descricao }}</span></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Tabela com os detalhes da Reclamação -->
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
                                    <td><strong>{{ __('Descrição') }}</strong></td>
                                    <td>{{ $reclamacao->descricao }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Condomínio') }}</strong></td>
                                    <td>{{ optional($reclamacao->condominio)->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Condómino') }}</strong></td>
                                    <td>{{ optional($reclamacao->user)->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Tipo de Reclamação') }}</strong></td>
                                    <td>{{ optional($reclamacao->tipoReclamacao)->tipo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Estado') }}</strong></td>
                                    <td>{{ optional($reclamacao->estado)->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Processo') }}</strong></td>
                                    <td>{{ $reclamacao->processo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Criação') }}</strong></td>
                                    <td>{{ $reclamacao->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Resolução') }}</strong></td>
                                    <td>{{ $reclamacao->resolved_at ? $reclamacao->resolved_at->format('d/m/Y') : __('Não resolvida') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Exibir anexos -->
                    @if($reclamacao->anexos)
                                    <div class="mb-4">
                                        <label class="font-weight-bold">{{ __('Anexos Atuais:') }}</label>
                                        <div class="row">
                                            @foreach(json_decode($reclamacao->anexos) as $anexo)
                                                                    @php
                                                                        $filePath = 'storage/anexos/' . $anexo;
                                                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                                    @endphp

                                                                    <div class="col-md-3">
                                                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                            <!-- Exibir imagem -->
                                                                            <img src="{{ asset($filePath) }}" alt="Anexo" class="img-thumbnail">
                                                                        @else
                                                                            <!-- Exibir botão de download -->
                                                                            <a href="{{ asset($filePath) }}" class="btn btn-primary btn-block" download>
                                                                                <i class="fas fa-download"></i> {{ pathinfo($anexo, PATHINFO_BASENAME) }}
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                    @endif

                    <!-- Ações para o admin ou criador da reclamação -->
                    @if(auth()->user()->role === 'admin' || auth()->id() === $reclamacao->user_id)
                        @if(is_null($reclamacao->resolved_at)) <!-- Só exibe os botões se resolved_at for NULL -->
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="btn btn-warning btn-lg mx-2">
                                    <i class="fas fa-edit"></i> {{ __('Editar') }}
                                </a>

                                <!-- Botão para abrir o modal de confirmação de exclusão -->
                                <button class="btn btn-danger btn-lg mx-2" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Botão de "Processar" para administrador ou gerente -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->id === $reclamacao->condominio->manager_id)

                        @if(is_null($reclamacao->resolved_at)) <!-- Só exibe o botão se resolved_at for NULL -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('reclamacoes.process', $reclamacao->id) }}" class="btn btn-info btn-lg mx-2">
                                    <i class="fas fa-cogs"></i> {{ __('Processar Reclamação') }}
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- Exibir botão de pagamento caso o estado seja "Espera de Pagamento" -->
                    @if($reclamacao->estado->nome === 'Espera de Pagamento')
                        <div class="mt-4">
                            <a href="{{ route('reclamacoes.pagamento', $reclamacao->id) }}"
                                class="btn btn-success btn-lg mx-2">
                                <i class="fas fa-credit-card"></i> {{ __('Efetuar Pagamento') }}
                            </a>
                        </div>
                    @endif

                    <!-- Notificação de erro ou sucesso -->
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
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirmar Exclusão') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Tem certeza que deseja apagar esta reclamação?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                <form action="{{ route('reclamacoes.destroy', $reclamacao->id) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.opacity = 0;
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 500);
            }, 5000);
        }

        if (successMessage) {
            setTimeout(function () {
                successMessage.style.opacity = 0;
                setTimeout(function () {
                    successMessage.style.display = 'none';
                }, 500);
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush