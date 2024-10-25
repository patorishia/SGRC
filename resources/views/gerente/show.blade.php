@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detalhes do Condomino') }}: {{ $condomino->nome }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <p class="font-semibold text-lg">Nome: {{ $condomino->nome }}</p>
        <p>Email: {{ $condomino->email }}</p>
        <p>Telefone: {{ $condomino->telefone }}</p>
        <p>Condomínio: {{ optional($condomino->condominio)->nome }}</p> <!-- Assumindo que você tenha uma relação definida -->
        <p>Data de Criação: {{ $condomino->created_at }}</p>
        <p>Data de Atualização: {{ $condomino->updated_at }}</p>

        @if(auth()->user()->role === 'admin')
            <div class="mt-4">
                <a href="{{ route('condominos.edit', $condomino->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    {{ __('Editar') }}
                </a>
                <form action="{{ route('condominos.destroy', $condomino->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Tem certeza que deseja apagar este condomino?')">
                        {{ __('Apagar') }}
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
