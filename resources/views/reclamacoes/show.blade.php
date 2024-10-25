@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detalhes da Reclamação') }}: {{ $reclamacao->descricao }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <p class="font-semibold text-lg">Descrição: {{ $reclamacao->descricao }}</p>
        <p>Condomínio: {{ optional($reclamacao->condominio)->nome }}</p> <!-- Assumindo que a relação está definida -->
        <p>Condomino: {{ optional($reclamacao->condomino)->nome }}</p> <!-- Assumindo que a relação está definida -->
        <p>Tipo de Reclamação: {{ optional($reclamacao->tipoReclamacao)->tipo }}</p> <!-- Assumindo que a relação está definida -->
        <p>Estado: {{ $reclamacao->estado }}</p>
        <p>Data de Criação: {{ $reclamacao->data_criacao }}</p>
        <p>Data de Resolução: {{ $reclamacao->data_resolucao }}</p>

        @if(auth()->user()->role === 'admin')
            <div class="mt-4">
                <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    {{ __('Editar') }}
                </a>
                <form action="{{ route('reclamacoes.destroy', $reclamacao->id) }}" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Tem certeza que deseja apagar esta reclamação?')">
        {{ __('Apagar') }}
    </button>
</form>

            </div>
        @endif
    </div>
@endsection
