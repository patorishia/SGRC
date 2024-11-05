<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Reclamação') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ route('reclamacoes.update', ['reclamaco' => $reclamacao->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <label for="condomino_id" class="block text-sm font-medium text-gray-700">ID do Condómino
                                (NIF):</label>
                            <input type="number" name="condomino_id" id="condomino_id"
                                value="{{ $reclamacao->condomino_id }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                        </div>
                        <div class="mt-4">
                            <label for="condominio_id"
                                class="block text-sm font-medium text-gray-700">Condomínio:</label>
                            <select name="condominio_id" id="condominio_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                @foreach ($condominios as $condominio)
                                    <option value="{{ $condominio->id }}" {{ $reclamacao->condominio_id == $condominio->id ? 'selected' : '' }}>{{ $condominio->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="tipo_reclamacao_id" class="block text-sm font-medium text-gray-700">Tipo de
                                Reclamação:</label>
                            <select name="tipo_reclamacao_id" id="tipo_reclamacao_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                @foreach ($tiposReclamacao as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição:</label>
                            <textarea name="descricao" id="descricao"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>{{ $reclamacao->descricao }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="estado" class="block text-gray-700">Estado:</label>
                            <select name="estado_id" id="estado_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                @foreach ($estadoReclamacao as $estado)
                                    <option value="{{ $estado->id }}"{{ $reclamacao->estado_id == $estado->id ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-4">
                                Atualizar
                            </button>
                            <a href="{{ route('reclamacoes.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-4">
                                Voltar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>