@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Tipos de Reclamação') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem tipos de reclamação -->
            @if($tiposReclamacao->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há tipos de reclamação.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Tabela com a listagem dos tipos de reclamação -->
                    <table id="tipos-reclamacao-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Tipo') }}</th>
                                <th>{{ __('Data de Criação') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tiposReclamacao as $tipo)
                                <tr>
                                    <td>{{ $tipo->tipo }}</td>
                                    <td>{{ $tipo->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('tipos_reclamacao.show', $tipo->id) }}" class="btn btn-info btn-sm">
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

        <!-- Botão para adicionar tipo de reclamação -->
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('tipos_reclamacao.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Tipo de Reclamação') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Inicialização do DataTables -->
    <script>
        $(document).ready(function () {
            $('#tipos-reclamacao-table').DataTable({
                language: {
                    url: '{{ asset("json/dataTables." . app()->getLocale() . ".json") }}'  // Caminho para o arquivo de tradução baseado no idioma
                }
            });
        });
    </script>
@endpush
