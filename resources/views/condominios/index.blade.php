@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Condomínios')}}</h1>
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
                    <!-- Tabela DataTables -->
                    <table id="condominios-table" class="table table-striped table-bordered">
                    <thead class="bg-gray text-white">
                            <tr>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Endereço') }}</th>
                                <th>{{ __('Cidade') }}</th>
                                <th>{{ __('Código Postal') }}</th>
                                <th >{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($condominios as $condominio)
                                <tr>
                                    <td>{{ $condominio->nome }}</td>
                                    <td>{{ $condominio->endereco }}</td>
                                    <td>{{ $condominio->cidade }}</td>
                                    <td>{{ $condominio->codigo_postal }}</td>
                                    <td class="text-center">
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

       <!-- Botão para adicionar condomínio (visível apenas para admin) -->
    @if(auth()->user()->role === 'admin')
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('condominios.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condomínio') }}
                </a>
            </div>
        </div>
    @endif
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#condominios-table').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "language": {
                    "search": "{{ __('procurar') }}:",
                    "info": "{{ __('Exibindo _START_ a _END_ de _TOTAL_ registos') }}",
                    "paginate": {
                        "previous": "{{ __('Anterior') }}",
                        "next": "{{ __('Próximo') }}"
                    }
                }
            });
        });
    </script>
@endpush
