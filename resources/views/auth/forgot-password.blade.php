<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Redefinir Password') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Liga o CSS -->
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Liga o JavaScript -->
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

        /* Estilos para o overlay (fundo escurecido) */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999; /* Fica atrás dos modais */
            display: none;
        }

        /* Estilos para o modal */
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
        
        /* Estilos para a barra de loading */
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
            0% { width: 0; }
            50% { width: 50%; }
            100% { width: 100%; }
        }

        /* Estilos para o campo de email e botão de envio */
        input::placeholder { color: #6b7280; } /* Cor do texto do placeholder */
        .email-input {
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
    </style>
</head>

<!-- Formulário de seleção de idioma -->
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

<body>
    <div class="card">
        <h2 class="text-2xl font-semibold text-center mb-4">{{ __('Redefinir Password') }}</h2>
        <p class="text-gray-600 text-center mb-6">{{ __('Insira o seu e-mail abaixo para receber o link de redefinição da password.') }}</p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 text-center" id="resetPasswordForm">
            @csrf
            <div>
                <input type="email" name="email" placeholder="{{ __('E-mail') }}" class="email-input" required>
            </div>
            <button type="submit" class="submit-button" id="submitButton">
                {{ __('Enviar Link de Redefinição da Password') }}
            </button>
            <!-- Barra de loading -->
            <div id="loadingBar" class="loading-bar" style="display: none;"></div>
        </form>
        
        <p class="text-sm mt-6 text-center">
            {{ __('Lembrou-se da sua Password?') }} <br>
            <a href="{{ route('home') }}" class="text-link">{{ __('Faça login') }}</a> .
        </p>
    </div>

    <!-- Overlay (fundo escurecido) -->
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
        <div class="modal-body" id="successMessage">{{ __('O e-mail de redefinição foi enviado com sucesso!') }}</div>
        <button class="modal-button" id="goHomeButton">{{ __('Voltar para o Login!') }}</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = document.getElementById('successModal');
            const successMessage = document.getElementById('successMessage');

            // Verifica se há uma mensagem de sucesso
            if ('{{ session('status') }}' === 'passwords.sent') {
                successMessage.innerText = '{{ __('O e-mail de redefinição foi enviado com sucesso!') }}';
                successModal.style.display = 'block'; // Mostra o modal de sucesso
            }

            const errorModal = document.getElementById('errorModal');
            const errorMessage = document.getElementById('errorMessage');

            // Verifica se há erros e mostra o modal de erro
            if ('{{ $errors->any() }}' == '1') {
                errorMessage.innerText = '{{ $errors->first() }}';
                errorModal.style.display = 'block'; // Mostra o modal de erro
            }

            // Fecha o modal de erro
            const closeErrorModal = document.getElementById('closeErrorModal');
            closeErrorModal.addEventListener('click', function() {
                errorModal.style.display = 'none';
            });

            // Fecha o modal de sucesso e redireciona
            const goHomeButton = document.getElementById('goHomeButton');
            goHomeButton.addEventListener('click', function() {
                window.location.href = '{{ route('home') }}';
            });
        });
    </script>
</body>
</html>
