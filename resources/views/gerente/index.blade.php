@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Condomínos') }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <!-- Botão para adicionar condomino -->
        <div class="mb-4">
            <a href="{{ route('gerente.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Adicionar Condomíno
            </a>
        </div>

        <!-- Listagem de condominos -->
        @if($condominos->isEmpty())
            <div class="text-center">
                <p class="text-lg text-gray-500">{{ __('Ainda não há nenhum condomino.') }}</p>
            </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($condominos as $condomino)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <a href="{{ route('gerente.show', $condomino->id) }}" class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                {{ $condomino->nome }}
            </a>
            <p class="text-gray-600 dark:text-gray-400">Email: {{ $condomino->email }}</p>
            <p class="text-gray-600 dark:text-gray-400">Telefone: {{ $condomino->telefone }}</p>
        </div>
    @endforeach
</div>

        @endif
    </div>
@endsection
