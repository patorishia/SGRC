@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Condomínio') }}: {{ $condominio->nome }}
    </h2>
@endsection

@section('content')
    <!-- Adding margin around the card to avoid it sticking to the edges -->
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">{{ __('Editar Condomínio') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('condominios.update', $condominio->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nome" class="block text-gray-700">{{ __('Nome') }}:</label>
                        <input type="text" name="nome" id="nome" value="{{ $condominio->nome }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="endereco" class="block text-gray-700">{{ __('Endereço') }}:</label>
                        <input type="text" name="endereco" id="endereco" value="{{ $condominio->endereco }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="cidade" class="block text-gray-700">{{ __('Cidade') }}:</label>
                        <input type="text" name="cidade" id="cidade" value="{{ $condominio->cidade }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="codigo_postal" class="block text-gray-700">{{ __('Código Postal') }}:</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" value="{{ $condominio->codigo_postal }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-warning">
                            {{ __('Atualizar Condomínio') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
