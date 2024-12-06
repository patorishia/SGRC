@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Condomínios') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem condomínios -->
            @if($condominios->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhum condomínio.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Tabela DataTables -->
                    <table id="condominios-table" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Endereço') }}</th>
                                <th>{{ __('Cidade') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($condominios as $condominio)
                                <tr>
                                    <td>{{ $condominio->nome }}</td>
                                    <td>{{ $condominio->endereco }}</td>
                                    <td>{{ $condominio->cidade }}</td>
                                    <td>
                                        <a href="{{ route('condominios.show', $condominio->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('Ver detalhes') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Botão para adicionar condomínio -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('condominios.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condomínio') }}
                </a>
            </div>
        </div>
    </div>
@endsection
