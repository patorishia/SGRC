@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Editar Tipo de Reclamação') }}: {{ $tipoReclamacao->tipo }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ __('Editar Tipo de Reclamação') }}: {{ $tipoReclamacao->tipo }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tipos_reclamacao.update', $tipoReclamacao->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
                                <input type="text" name="tipo" id="tipo" value="{{ $tipoReclamacao->tipo }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">{{ __('Descrição') }}</label>
                                <textarea name="descricao" id="descricao" class="form-control" required>{{ $tipoReclamacao->descricao }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> {{ __('Atualizar') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
