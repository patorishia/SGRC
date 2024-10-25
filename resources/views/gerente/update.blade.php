@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Condomino') }}: {{ $condomino->nome }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('condominos.update', $condomino->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nome" class="block text-gray-700">Nome:</label>
                <input type="text" name="nome" id="nome" value="{{ $condomino->nome }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" name="email" id="email" value="{{ $condomino->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="telefone" class="block text-gray-700">Telefone:</label>
                <input type="text" name="telefone" id="telefone" value="{{ $condomino->telefone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="condominio_id" class="block text-gray-700">Condomínio:</label>
                <select name="condominio_id" id="condominio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @foreach($condominios as $condominio)
                        <option value="{{ $condominio->id }}" {{ $condomino->condominio_id == $condominio->id ? 'selected' : '' }}>
                            {{ $condominio->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Atualizar
            </button>
        </form>
    </div>
@endsection
