@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Adicionar Condomínio') }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- Formulário para criar condomínio -->
            <form action="{{ route('condominios.store') }}" method="POST">
                @csrf
                
                <!-- Campo Nome -->
                <div class="mb-4">
                    <label for="nome" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Nome') }}</label>
                    <input type="text" name="nome" id="nome" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Campo Endereço -->
                <div class="mb-4">
                    <label for="endereco" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Endereço') }}</label>
                    <input type="text" name="endereco" id="endereco" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Campo Cidade -->
                <div class="mb-4">
                    <label for="cidade" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Cidade') }}</label>
                    <input type="text" name="cidade" id="cidade" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Campo Código Postal -->
                <div class="mb-4">
                    <label for="codigo_postal" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Código Postal') }}</label>
                    <input type="text" name="codigo_postal" id="codigo_postal" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Campo Data de Criação (automático) -->
                <div class="mb-4">
                    <label for="created_at" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Data de Criação') }}</label>
                    <input type="date" name="created_at" id="created_at" value="{{ date('Y-m-d') }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" readonly>
                </div>

                <!-- Botão de Enviar -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('Salvar Condomínio') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
