<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Redefinir palavra-passe') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        /* Estilo de fundo da página */
        body {
            background-image: url('{{ asset('images/bg2.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilo do cartão que envolve o formulário */
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }

        /* Estilos para a sobreposição (overlay) que aparece no fundo */
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

        /* Estilos para o modal de erro e sucesso */
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
        
        /* Estilo para o cabeçalho do modal */
        .modal-header {
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        /* Estilo para o corpo do modal */
        .modal-body {
            margin-bottom: 1.5rem;
        }
        
        /* Estilos para o botão do modal */
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

        /* Efeito do botão do modal ao passar o cursor por cima */
        .modal-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }

        /* Barra de carregamento */
        .loading-bar {
            position: relative;
            width: 100%;
            height: 4px;
            background-color: #e0e0e0;
            overflow: hidden;
            border-radius: 2px;
        }
        
        /* Animação da barra de carregamento */
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

        /* Estilo do placeholder nos campos de input */
        input::placeholder {
            color: #6b7280;
        }

        /* Estilo para os campos de entrada de email e palavra-passe */
        .email-input {
            padding: 1rem;
            border-radius: 0.375rem;
            border: 1px solid #ccc;
            width: 93%;
            margin-bottom: 1rem;
        }

        /* Estilo para o botão de envio */
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

        /* Efeito do botão de envio ao passar o cursor por cima */
        .submit-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }
    </style>
</head>

<!-- Formulário para troca de idioma -->
<div style="position: absolute; top: 10px; right: 10px;">
    <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
        @csrf
        <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
            <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>{{ __('Português (Portugal)') }}</option>
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('English (US)') }}</option>
            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français (France)</option>
        </select>
    </form>
</div>

<body>
<div class="card">
    <h2 class="text-2xl font-semibold text-center mb-4">{{ __('Redefinir palavra-passe') }}</h2>
    <p class="text-gray-600 text-center mb-6">{{ __('Insira a nova palavra-passe para sua conta.') }}</p>

    <!-- Formulário de redefinição de palavra-passe -->
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4 text-center" id="resetPasswordForm">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Campo para o email -->
        <div>
            <input id="email" class="email-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="{{ __('Email') }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo para a nova palavra-passe -->
        <div>
            <input id="password" class="email-input" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('Nova palavra-passe') }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Campo para confirmar a nova palavra-passe -->
        <div>
            <input id="password_confirmation" class="email-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirmar Nova palavra-passe') }}" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botão para submeter o formulário -->
        <button type="submit" class="submit-button" id="submitButton">
            {{ __('Redefinir palavra-passe') }}
        </button>

        <!-- Barra de carregamento -->
        <div id="loadingBar" class="loading-bar" style="display: none;"></div>
    </form>
</div>

<!-- Modal de erro -->
<div class="overlay" id="overlay"></div>

<div class="modal" id="errorModal">
    <div class="modal-header">{{ __('Erro') }}</div>
    <div class="modal-body" id="errorMessage">{{ __('Mensagem de erro aqui.') }}</div>
    <button class="modal-button" id="closeErrorModal">{{ __('Fechar') }}</button>
</div>

<!-- Modal de sucesso -->
<div class="modal" id="successModal">
    <div class="modal-header">{{ __('Sucesso') }}</div>
    <div class="modal-body" id="successMessage">{{ __('O e-mail de redefinição foi enviado com sucesso!') }}</div>
    <button class="modal-button" id="goHomeButton">{{ __('Voltar para o Login!') }}</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar o modal de sucesso caso o e-mail de redefinição tenha sido enviado
        const successModal = document.getElementById('successModal');
        const successMessage = document.getElementById('successMessage');
        
        if ('{{ session('status') }}' === 'passwords.sent') {
            successMessage.innerText = '{{ __('O e-mail de redefinição foi enviado com sucesso!') }}';
            successModal.style.display = 'block';
        }

        // Mostrar o modal de erro caso haja algum erro de validação
        const errorModal = document.getElementById('errorModal');
        const errorMessage = document.getElementById('errorMessage');

        if ('{{ $errors->any() }}' == '1') {
            errorMessage.innerText = '{{ $errors->first() }}';
            errorModal.style.display = 'block';
        }

        // Fechar o modal de erro ao clicar no botão de fechar
        const closeErrorModal = document.getElementById('closeErrorModal');
        closeErrorModal.addEventListener('click', function() {
            errorModal.style.display = 'none';
        });

        // Redirecionar para a página inicial após clicar no botão "Voltar para o Login"
        const goHomeButton = document.getElementById('goHomeButton');
        goHomeButton.addEventListener('click', function() {
            window.location.href = '{{ route('home') }}';
        });
    });
</script>

</body>
</html>
