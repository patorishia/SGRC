@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Tipo de Reclamação') }}: {{ $tipoReclamacao->tipo }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('tipos_reclamacao.update', $tipoReclamacao->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="tipo" class="block text-gray-700">Tipo:</label>
                <input type="text" name="tipo" id="tipo" value="{{ $tipoReclamacao->tipo }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700">Descrição:</label>
                <textarea name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ $tipoReclamacao->descricao }}</textarea>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Atualizar
            </button>
        </form>
    </div>
@endsection
