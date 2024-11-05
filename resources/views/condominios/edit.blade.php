<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Condomínio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form action="{{ route('condominios.update', $condominio->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Condomínio</label>
                            <input type="text" name="nome" id="nome" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ $condominio->nome }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ $condominio->endereco }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ $condominio->cidade }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" name="codigo_postal" id="codigo_postal" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ $condominio->codigo_postal }}" required>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-4">
                                Salvar
                            </button>
                            <a href="{{ route('condominios.index') }}"
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
