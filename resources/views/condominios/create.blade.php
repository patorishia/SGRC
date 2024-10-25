<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Condomínio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('condominios.store') }}" method="POST">
                        @csrf
                        
                        <!-- Nome do Condomínio -->
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nome do Condomínio
                            </label>
                            <input type="text" name="nome" id="nome" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Endereço -->
                        <div class="mb-4">
                            <label for="endereco" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Endereço
                            </label>
                            <input type="text" name="endereco" id="endereco" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Cidade -->
                        <div class="mb-4">
                            <label for="cidade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Cidade
                            </label>
                            <input type="text" name="cidade" id="cidade" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Código Postal -->
                        <div class="mb-4">
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Código Postal
                            </label>
                            <input type="text" name="codigo_postal" id="codigo_postal" class="form-input mt-1 block w-full" required>
                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end">
                            <a href="{{ route('condominios.index') }}" class="btn btn-secondary me-3">
                                Voltar
                            </a>
                            <button type="submit" class="btn btn-success">
                                Criar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
