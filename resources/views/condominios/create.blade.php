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
    <!-- Card principal com mais margem e espaçamento -->
    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl ">{{ __('Adicionar Condomínio') }}</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('condominios.store') }}" method="POST">
                    @csrf

                    <!-- Campo Nome -->
                    <div class="form-group mb-4">
                        <label for="nome" class="control-label">{{ __('Nome') }}:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>

                    <!-- Campo Endereço -->
                    <div class="form-group mb-4">
                        <label for="endereco" class="control-label">{{ __('Endereço') }}:</label>
                        <input type="text" name="endereco" id="endereco" class="form-control" required>
                    </div>

                    <!-- Campo Cidade -->
                    <div class="form-group mb-4">
                        <label for="cidade" class="control-label">{{ __('Cidade') }}:</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" required>
                    </div>

                    <!-- Campo Código Postal -->
                    <div class="form-group mb-4">
                        <label for="codigo_postal" class="control-label">{{ __('Código Postal') }}:</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" required>
                    </div>

                    <!-- Campo Manager -->
                    <div class="form-group mb-4">
                        <label for="manager_id" class="control-label">{{ __('Manager') }}</label>
                        <input type="text" class="form-control" id="manager_id" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <!-- Campo Data de Criação (automático) -->
                    <div class="form-group mb-4">
                        <label for="created_at" class="control-label">{{ __('Data de Criação') }}:</label>
                        <input type="date" name="created_at" id="created_at" value="{{ date('Y-m-d') }}" class="form-control" readonly>
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> {{ __('Criar Condomínio') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
