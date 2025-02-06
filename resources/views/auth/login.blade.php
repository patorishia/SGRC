<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Iniciar Sessão') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        body {
            background-image: url('{{ asset('images/bg2.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }

        .input-field {
            padding: 1rem;
            border-radius: 0.375rem;
            border: 1px solid #ccc;
            width: 93%;
            margin-bottom: 1rem;
        }

        .submit-button {
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5);
            color: white;
            padding: 0.75rem;
            width: 100%;
            text-align: center;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
        }

        .submit-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
            width: 90%;
            max-width: 400px;
        }

        .modal-header {
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-button {
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }

        .modal-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }

        .loading-bar {
            position: relative;
            width: 100%;
            height: 4px;
            background-color: #e0e0e0;
            overflow: hidden;
            border-radius: 2px;
        }

        .loading-bar::before {
            content: '';
            position: absolute;
            width: 0;
            height: 100%;
            background-color: #4f46e5;
            animation: loadingAnimation 2s infinite;
        }

        @keyframes loadingAnimation {
            0% {
                width: 0;
            }
            50% {
                width: 50%;
            }
            100% {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div style="position: absolute; top: 10px; right: 10px;">
        <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
            @csrf
            <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
                <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>Português (Portugal)</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English (US)</option>
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français (France)</option>
            </select>
        </form>
    </div>

    <div class="card">
        <h2 class="text-2xl font-semibold text-center mb-4">{{ __('Iniciar Sessão') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Endereço de E-mail')" />
                <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('palavra-passe')" />
                <x-text-input id="password" class="input-field"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembrar-me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Esqueceu-se da sua palavra-passe?') }}
                    </a>
                @endif

                <x-primary-button class="submit-button ms-3">
                    {{ __('Iniciar Sessão') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Overlay (background dim) -->
    <div class="overlay" id="overlay"></div>

    <!-- Modal de erro -->
    <div class="modal" id="errorModal">
        <div class="modal-header">{{ __('Erro') }}</div>
        <div class="modal-body" id="errorMessage">{{ __('Mensagem de erro aqui.') }}</div>
        <button class="modal-button" id="closeErrorModal">{{ __('Fechar') }}</button>
    </div>

    <!-- Modal de sucesso -->
    <div class="modal" id="successModal">
        <div class="modal-header">{{ __('Sucesso') }}</div>
        <div class="modal-body" id="successMessage">{{ __('O login foi bem-sucedido!') }}</div>
        <button class="modal-button" id="goHomeButton">{{ __('Ir para o Painel') }}</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = document.getElementById('successModal');
            const successMessage = document.getElementById('successMessage');

            if ('{{ session('status') }}' === 'login.success') {
                successMessage.innerText = '{{ __('O login foi bem-sucedido!') }}';
                successModal.style.display = 'block'; 
            }

            const errorModal = document.getElementById('errorModal');
            const errorMessage = document.getElementById('errorMessage');

            if ('{{ $errors->any() }}' == '1') {
                errorMessage.innerText = '{{ $errors->first() }}';
                errorModal.style.display = 'block'; 
            }

            const closeErrorModal = document.getElementById('closeErrorModal');
            closeErrorModal.addEventListener('click', function() {
                errorModal.style.display = 'none';
            });

            const goHomeButton = document.getElementById('goHomeButton');
            goHomeButton.addEventListener('click', function() {
                window.location.href = '{{ route('dashboard') }}';
            });
        });
    </script>

</body>
</html>
