<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmação de Recebimento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>{{ __('Olá') }} {{ $dados['nome'] }},</p>
                    <p>{{ __('Sua reclamação foi recebida com sucesso!') }}</p>
                    <p><strong>{{ __('Descrição:') }}</strong> {{ $dados['descricao'] }}</p>
                    <p>{{ __('Agradecemos pela sua colaboração!') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

