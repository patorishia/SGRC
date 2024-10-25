@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Reclamações') }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <!-- Botão para adicionar reclamação -->
        <div class="mb-4">
            <a href="{{ route('reclamacoes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Adicionar Reclamação
            </a>
        </div>

        <!-- Listagem de reclamações -->
        @if($reclamacoes->isEmpty())
            <div class="text-center">
                <p class="text-lg text-gray-500">{{ __('Ainda não há nenhuma reclamação.') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($reclamacoes as $reclamacao)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <a href="{{ route('reclamacoes.show', $reclamacao->id) }}" class="font-semibold text-lg text-gray-800 dark:text-gray-200">
            {{ $reclamacao->descricao }}
        </a>
        <p>Condomínio: {{ optional($reclamacao->condominio)->nome }}</p>
        <p>Condomino: {{ optional($reclamacao->condomino)->nome }}</p>
        <p>Estado: {{ $reclamacao->estado }}</p>
    </div>
@endforeach

            </div>
        @endif
    </div>
@endsection
