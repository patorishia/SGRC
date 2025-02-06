@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Minhas Reclamações')}}</h1>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verifica se não existem reclamações -->
            @if($reclamacoes->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhuma reclamação.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Tabela de reclamações -->
                    <table id="reclamacoes-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Descrição') }}</th>
                                <th>{{ __('Condomínio') }}</th>
                                <th>{{ __('Estado') }}</th>
                                <th>{{ __('Data de Criação') }}</th>
                                <th>{{ __('Ações') }}</th> <!-- Coluna para Ações -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iteração sobre as reclamações -->
                            @foreach($reclamacoes as $reclamacao)
                                <tr>
                                    <td>{{ $reclamacao->descricao }}</td>
                                    <td>{{ optional($reclamacao->condominio)->nome }}</td>
                                    <td>{{ optional($reclamacao->estado)->nome }}</td>
                                    <td>{{ $reclamacao->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <!-- Botão para visualizar os detalhes da reclamação -->
                                        <a href="{{ route('reclamacoes.show', $reclamacao->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i> {{ __('Ver Detalhes') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Botão para adicionar uma nova reclamação -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('reclamacoes.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Reclamação') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Inicializa a tabela de reclamações com o DataTables
            $('#reclamacoes-table').DataTable({
                language: {
                    url: '{{ asset("json/dataTables." . app()->getLocale() . ".json") }}'
                }
            });
        });
    </script>
@endpush
