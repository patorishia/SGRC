@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Condomínos') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem condomínios -->
            @if($condominos->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhum condomíno.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Tabela de listagem dos condomínios -->
                    <table id="condominios-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Telefone') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($condominos as $condomino)
                                <tr>
                                    <td>{{ $condomino->nome }}</td>
                                    <td>{{ $condomino->email }}</td>
                                    <td>{{ $condomino->telefone }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('gerente.show', $condomino->nif) }}" class="btn btn-info btn-sm">
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

        <!-- Botão para adicionar condomíno -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('gerente.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condómino') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Inicialização do DataTables -->
    <script>
        $(document).ready(function () {
            $('#condominios-table').DataTable({
                language: {
                    url: '{{ asset("json/dataTables." . app()->getLocale() . ".json") }}'  // Caminho para o arquivo de tradução baseado no idioma
                }
            });
        });
    </script>
@endpush
