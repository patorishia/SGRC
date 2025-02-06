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

<!-- Card principal com mais margem e espaçamento -->
<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl">{{ __('Adicionar Tipo de Reclamação') }}</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('tipos_reclamacao.store') }}" method="POST">
                @csrf

                <!-- Campo Tipo -->
                <div class="form-group mb-4">
                    <label for="tipo" class="control-label">{{ __('Tipo') }}:</label>
                    <input type="text" name="tipo" id="tipo" class="form-control" required>
                </div>

                <!-- Campo Descrição -->
                <div class="form-group mb-4">
                    <label for="descricao" class="control-label">{{ __('Descrição') }}:</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
                </div>

                <!-- Botão de Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> {{ __('Adicionar Tipo de Reclamação') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
