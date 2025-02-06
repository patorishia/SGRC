@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="text-dark mb-4">{{ __('Tipos de Reclamação') }}</h3>
            </div>
        </div>
    </div>
</div>

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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-gray text-white">
                            <tr>
                                <th class="text-center text-shadow">{{ __('Tipo') }}</th>
                                <th class="text-center text-shadow">{{ __('Data de Criação') }}</th>
                                <th class="text-center text-shadow">{{ __('Ações') }}</th>
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
            </div>
        @endif
    </div>

    <!-- Botão para adicionar tipo de reclamação -->
    <div class="row">
        <div class="col-12 text-center mt-4">
            <a href="{{ route('tipos_reclamacao.create') }}" class="btn btn-success btn-lg">
                <i class="fas fa-plus-circle"></i> {{ __('Adicionar Tipo de Reclamação') }}
            </a>
        </div>
    </div>
</div>

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
