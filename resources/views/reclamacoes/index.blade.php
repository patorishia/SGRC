@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Reclamações') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem reclamações -->
            @if($reclamacoes->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhuma reclamação.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Tabela de listagem das reclamações -->
                    <table id="reclamacoes-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Descrição') }}</th>
                                <th>{{ __('Condomínio') }}</th>
                                <th>{{ __('Condómino') }}</th>
                                <th>{{ __('Estado') }}</th>
                                <th>{{ __('Data de Criação') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reclamacoes as $reclamacao)
                                <tr>
                                    <td>{{ $reclamacao->descricao }}</td>
                                    <td>{{ optional($reclamacao->condominio)->nome }}</td>
                                    <td>{{ optional($reclamacao->condomino)->nome }}</td>
                                    <td>{{ optional($reclamacao->Estado)->nome }}</td>
                                    <td>{{ $reclamacao->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('reclamacoes.show', $reclamacao->id) }}" class="btn btn-info btn-sm">
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

        <!-- Botões para exportação (visíveis apenas para admins) -->
        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('reclamacoes.export.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> {{ __('Exportar para Excel') }}
                    </a>
                    <a href="{{ route('reclamacoes.export.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> {{ __('Exportar para PDF') }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Botão para adicionar reclamação -->
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
    <!-- Inicialização do DataTables -->
    <script>
        $(document).ready(function () {
            $('#reclamacoes-table').DataTable({
                language: {
                    url: '{{ asset("json/dataTables." . app()->getLocale() . ".json") }}'  // Caminho para o arquivo de tradução baseado no idioma
                }
            });
        });
    </script>
@endpush
