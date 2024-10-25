<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Reclamações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <a href="{{ route('reclamacoes.create') }}" class="btn btn-primary mb-4">Adicionar Reclamação</a>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condomínio ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condomino ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Reclamação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atualizado em</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reclamacoes as $reclamacao)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->condominio_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->condomino_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->tipo_reclamacao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->descricao }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->estado }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reclamacao->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('reclamacoes.edit', $reclamacao->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                        <form action="{{ route('reclamacoes.destroy', $reclamacao->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
