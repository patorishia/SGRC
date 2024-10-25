@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-900 leading-tight">
        {{ __('Editar Condomínio') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('condominios.update', $condominio->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nome" class="block font-medium text-sm text-black">{{ __('Nome') }}</label>
                            <input type="text" name="nome" id="nome" value="{{ $condominio->nome }}" required class="block mt-1 w-full">
                        </div>

                        <div class="mt-4">
                            <label for="endereco" class="block font-medium text-sm text-black">{{ __('Endereço') }}</label>
                            <input type="text" name="endereco" id="endereco" value="{{ $condominio->endereco }}" required class="block mt-1 w-full">
                        </div>

                        <div class="mt-4">
                            <label for="cidade" class="block font-medium text-sm text-black">{{ __('Cidade') }}</label>
                            <input type="text" name="cidade" id="cidade" value="{{ $condominio->cidade }}" required class="block mt-1 w-full">
                        </div>

                        <div class="mt-4">
                            <label for="codigo_postal" class="block font-medium text-sm text-black">{{ __('Código Postal') }}</label>
                            <input type="text" name="codigo_postal" id="codigo_postal" value="{{ $condominio->codigo_postal }}" required class="block mt-1 w-full">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                {{ __('Atualizar Condomínio') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
