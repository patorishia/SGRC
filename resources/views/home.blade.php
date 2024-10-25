<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Gestão de Reclamações de Condomínios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <p class="mb-6 text-lg">{{ __("Bem-vindo ao nosso sistema de gestão de reclamações. Você pode registrar e acompanhar suas reclamações de forma fácil e eficiente. Estamos aqui para ajudar!") }}</p>

                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-lg text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out transform hover:scale-105">
                            {{ __('Registrar') }}
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-lg text-base font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out transform hover:scale-105">
                            {{ __('Login') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
