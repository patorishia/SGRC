@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Adicionar Condomínio') }}
    </h2>
@endsection

@section('content')
    <!-- Card principal com margem adequada -->
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">{{ __('Adicionar Condomínio') }}</h3>
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

                    <!-- Campo Data de Criação (automático) -->
                    <div class="form-group mb-4">
                        <label for="created_at" class="control-label">{{ __('Data de Criação') }}:</label>
                        <input type="date" name="created_at" id="created_at" value="{{ date('Y-m-d') }}" class="form-control" readonly>
                    </div>

                    <!-- Botão de Enviar -->
                    <button type="submit" class="btn btn-success">
                        Criar Condominio
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
