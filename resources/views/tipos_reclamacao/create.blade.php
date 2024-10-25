@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Adicionar Tipo de Reclamação') }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('tipos_reclamacao.store') }}" method="POST">
            @csrf
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <input type="text" name="tipo" id="tipo" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" />
            </div>
            <div class="mt-4">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea name="descricao" id="descricao" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"></textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Adicionar') }}
                </button>
            </div>
        </form>
    </div>
@endsection
