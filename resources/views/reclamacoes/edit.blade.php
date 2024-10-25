@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Reclamação') }}: {{ $reclamacao->descricao }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('reclamacoes.update', $reclamacao->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="condomino_id" class="block text-gray-700">Condomino:</label>
                <select name="condomino_id" id="condomino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @foreach($condominos as $condomino)
                        <option value="{{ $condomino->id }}" {{ $reclamacao->condomino_id == $condomino->id ? 'selected' : '' }}>
                            {{ $condomino->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="condominio_id" class="block text-gray-700">Condomínio:</label>
                <select name="condominio_id" id="condominio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @foreach($condominios as $condominio)
                        <option value="{{ $condominio->id }}" {{ $reclamacao->condominio_id == $condominio->id ? 'selected' : '' }}>
                            {{ $condominio->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="tipo_reclamacao" class="block text-gray-700">Tipo de Reclamação:</label>
                <select name="tipo_reclamacao" id="tipo_reclamacao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @foreach($tipos_reclamacao as $tipo)
                        <option value="{{ $tipo->id }}" {{ $reclamacao->tipo_reclamacao == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700">Descrição:</label>
                <textarea name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ $reclamacao->descricao }}</textarea>
            </div>

            <div class="mb-4">
                <label for="estado" class="block text-gray-700">Estado:</label>
                <input type="text" name="estado" id="estado" value="{{ $reclamacao->estado }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Atualizar
            </button>
        </form>
    </div>
@endsection
