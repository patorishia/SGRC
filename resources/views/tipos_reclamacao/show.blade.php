@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detalhes do Tipo de Reclamação') }}: {{ $tiposReclamacao->tipo }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <p class="font-semibold text-lg">Tipo: {{ $tiposReclamacao->tipo }}</p>
        <p>Descrição: {{ $tiposReclamacao->descricao }}</p>
        <p>Data de Criação: {{ $tiposReclamacao->created_at }}</p>
        <p>Data de Atualização: {{ $tiposReclamacao->updated_at }}</p>
        <a href="{{ route('tipos_reclamacao.edit', $tiposReclamacao->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Editar</a>
        <form action="{{ route('tipos_reclamacao.destroy', $tiposReclamacao->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Tem certeza que deseja apagar este condomino?')">
                        {{ __('Apagar') }}
                    </button>
                </form>
    </div>
@endsection
