@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Condóminos')}}</h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Verificar se existem condomínios -->
        @if($condominios->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted">{{ __('Ainda não há nenhum condomínio.') }}</p>
            </div>
        @else
            <div class="col-12">
                <!-- Accordion-style Expandable Widgets para cada condomínio -->
                <div class="accordion" id="condominiosAccordion">
                    @foreach($condominios as $index => $condominio)
                        <!-- Verificar se o utilizador é administrador ou o gerente do condomínio atual -->
                        @if(Auth::user()->role == 'admin' || $condominio->manager_id == Auth::id())
                            <div class="card">
                                <div class="card-header" id="heading{{ $index }}" style="background-color: #d4d4d4;" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    <h5 class="mb-0" style="color: black; font-size: 1.3rem; font-weight: bold; text-decoration: none;">
                                        {{ $condominio->nome }}
                                    </h5>
                                </div>

                                <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#condominiosAccordion">
                                    <div class="card-body">
                                        <!-- Tabela de utilizadores para o condomínio selecionado -->
                                        <h4>{{ __('Condóminos do Condomínio:') }}</h4>
                                        @if($condominio->users->isEmpty())
                                            <p>{{ __('Ainda não há condóminos neste condomínio.') }}</p>
                                        @else
                                            <table class="table table-striped">
                                                <thead class="bg-gray text-white">
                                                    <tr>
                                                        <th>{{ __('Nome') }}</th>
                                                        <th>{{ __('Email') }}</th>
                                                        <th>{{ __('Ações') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($condominio->users as $user)
                                                        <tr>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i> {{ __('Ver detalhes') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Botão para adicionar utilizador -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('users.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condómino') }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-condominio-name {
        color: black; /* Definir a cor do texto para preto */
        font-size: 1.5rem; /* Aumentar o tamanho do texto */
        font-weight: bold; /* Tornar o texto em negrito */
        text-decoration: none; /* Remover o sublinhado do link */
    }

    .custom-condominio-name:hover {
        color: #0056b3; /* Cor que muda ao passar o rato por cima */
        text-decoration: none; /* Garantir que não há sublinhado ao passar o rato */
    }
</style>
@endpush

@push('scripts')
<!-- jQuery e Bootstrap JS (necessários para a funcionalidade do accordion) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        // jQuery para alternar o comportamento de colapso: se já estiver aberto, fecha-o
        $('#condominiosAccordion .card-header').click(function() {
            var target = $(this).attr('data-target');
            var currentState = $(target).hasClass('show');
            
            // Se o accordion clicado já estiver aberto, fecha-o
            if (currentState) {
                $(target).collapse('hide');
            }
        });
    });
</script>
@endpush
