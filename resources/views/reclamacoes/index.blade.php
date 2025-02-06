@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Reclamações')}}</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Filtro de reclamações -->
        <div class="col-12">
            <form method="GET" action="{{ route('reclamacoes.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="condominio">{{ __('Condomínio') }}</label>
                            <select name="condominio" id="condominio" class="form-control">
                                <option value="">{{ __('Selecione um Condomínio') }}</option>
                                @foreach($condominios as $condominio)
                                    <option value="{{ $condominio->id }}" {{ request('condominio') == $condominio->id ? 'selected' : '' }}>
                                        {{ $condominio->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user">{{ __('Condómino') }}</label>
                            <select name="user" id="user" class="form-control">
                                <option value="">{{ __('Selecione um Condómino') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado">{{ __('Estado') }}</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="">{{ __('Selecione um Estado') }}</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ request('estado') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Filtrar') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Verificar se existem reclamações -->
        @if($reclamacoes->isEmpty())
            <div class="col-12 text-center">
                <p class="text-muted">{{ __('Ainda não há nenhuma reclamação.') }}</p>
            </div>
        @else
            <div class="col-12">
                <!-- Tabela de listagem das reclamações -->
                <table id="reclamacoes-table" class="table table-bordered table-striped">
                    <thead class="bg-gray text-white">
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
                                <td>{{ optional($reclamacao->user)->name }}</td>
                                <td>{{ optional($reclamacao->estado)->nome }}</td>
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
    @if(Auth::user()->role == 'admin' || \App\Models\Condominio::where('manager_id', Auth::id())->exists())
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('reclamacoes.export.excel', [
                    'condominio' => request('condominio'),
                    'user' => request('user'),
                    'estado' => request('estado'),
                    'sort_by' => 'descricao', 
                    'sort_order' => 'asc'     
                ]) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> {{ __('Exportar para Excel') }}
                </a>
                <a href="{{ route('reclamacoes.export-pdf', request()->query()) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> {{ __('Exportar para PDF') }}
                </a>
            </div>
        </div>
    @endif
    @if(Auth::user()->role == 'admin')
    <!-- Botão para adicionar reclamação -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('reclamacoes.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> {{ __('Adicionar Reclamação') }}
            </a>
        </div>
    </div>
    @endif
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
