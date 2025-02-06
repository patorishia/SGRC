@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="text-dark mb-4">{{ __('Detalhes do Usuário') }}: <span class="text-primary">{{ $user->name }}</span></h3>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Tabela de detalhes do utilizador em estilo de cartão -->
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
                                <!-- Detalhes do utilizador -->
                                <tr>
                                    <td><strong>{{ __('Nome') }}</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Email') }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('NIF') }}</strong></td>
                                    <td>{{ $user->nif }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Telefone') }}</strong></td>
                                    <td>{{ $user->telefone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Condomínio') }}</strong></td>
                                    <td>{{ $user->condominio->nome }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Papel') }}</strong></td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Criação') }}</strong></td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('Data de Atualização') }}</strong></td>
                                    <td>{{ $user->updated_at->format('d/m/Y') }}</td>
                                </tr>
                                @if(auth()->user()->role === 'admin' && !$user->hasVerifiedEmail())
                                    <!-- Verificação de email para administradores -->
                                    <tr>
                                        <td><strong>{{ __('Verificação de Email') }}</strong></td>
                                        <td>
                                            <form action="{{ route('users.resendVerificationEmail', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm rounded-pill">
                                                    <i class="fas fa-envelope"></i> {{ __('Reenviar Email de Verificação ao Admin') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @elseif($user->hasVerifiedEmail())
                                    <!-- Mostrar que o email foi verificado -->
                                    <tr>
                                        <td><strong>{{ __('Verificação de Email') }}</strong></td>
                                        <td>{{ __('Este Condomino já está verificado') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Botões de ação para o administrador -->
                    @if(auth()->user()->role === 'admin')
                        <div class="d-flex justify-content-center mt-4">
                            <!-- Botão para editar utilizador -->
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-lg mx-2">
                                <i class="fas fa-edit"></i> {{__('Editar') }}
                            </a>

                            <!-- Botão para abrir modal de confirmação de exclusão -->
                            <button type="button" class="btn btn-danger btn-lg mx-2" data-toggle="modal" data-target="#confirmDeleteModal">
                                <i class="fas fa-trash-alt"></i> {{ __('Apagar') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal para confirmação de exclusão -->
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
                            {{ __('Tem certeza de que deseja apagar este condómino? Esta ação não pode ser desfeita.') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('Apagar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exibição de mensagens de erro ou sucesso -->
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
    // Função para esconder mensagens de erro ou sucesso após um atraso
    window.onload = function() {
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.opacity = 0;
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 500);
            }, 5000);
        }

        if (successMessage) {
            setTimeout(function() {
                successMessage.style.opacity = 0;
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500);
            }, 5000);
        }
    }
</script>

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
@endsection
