@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-900 leading-tight">
        {{ __('Detalhes do Condomínio') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">{{ $condominio->nome }}</h3>
                    <p>Endereço: {{ $condominio->endereco }}</p>
                    <p>Cidade: {{ $condominio->cidade }}</p>
                    <p>Código Postal: {{ $condominio->codigo_postal }}</p>
                    <p>Criado em: {{ $condominio->created_at->format('d/m/Y') }}</p>
                    <p>Atualizado em: {{ $condominio->updated_at->format('d/m/Y') }}</p>

                    <!-- Mostrar botões apenas se o usuário for admin -->
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('condominios.edit', $condominio->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                {{ __('Editar') }}
                            </a>
                            <form action="{{ route('condominios.destroy', $condominio->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Tem certeza que deseja apagar este condomínio?')">
                                    {{ __('Apagar') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
