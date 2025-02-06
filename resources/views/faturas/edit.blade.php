@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Fatura</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <form id="editInvoiceForm" method="POST" action="{{ route('faturas.update', $fatura->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detalhes da Fatura</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="invoice_id">ID da Fatura</label>
                                <input type="text" class="form-control" id="invoice_id" name="invoice_id" value="{{ $fatura->id }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="date">Data</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $fatura->date }}">
                            </div>
                            <div class="form-group">
                                <label for="client">Cliente</label>
                                <input type="text" class="form-control" id="client" name="client" value="{{ $fatura->name }}">
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ $fatura->total }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ $fatura->description }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                            <a href="{{ route('faturas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
     
    </script>
@endsection
