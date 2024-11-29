@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Condomino') }}: {{ $condomino->nome }}
    </h2>
@endsection

@section('content')
    <!-- Adding margin around the card to avoid it sticking to the edges -->
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">Editar Condomino</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('gerente.update', $condomino->nif) }}" method="POST">
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

                    <button type="submit" class="btn btn-warning">
                        Atualizar
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
