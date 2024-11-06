<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('build/assets/bg2.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            animation: popupAnimation 0.3s ease-in-out;
        }
        .popup-button {
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }
        .popup-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }
        .popup-success {
            background-color: white;
            border: 2px solid #4CAF50;
            color: #4CAF50;
        }
        .popup-header {
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .text-link {
            color: #4f46e5;
            transition: color 0.3s ease;
        }
        .text-link:hover {
            color: #3b82f6;
        }
        /* Animação do spinner */
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
        @keyframes popupAnimation {
            0% {
                opacity: 0;
                transform: translate(-50%, -40%);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</head>
<body>
    <div class="bg-blue-500 shadow-lg rounded-lg max-w-2xl w-full flex text-white">
        <div class="w-full bg-white rounded-lg p-8 text-gray-800">
            <h2 class="text-2xl font-semibold text-center mb-4">Redefinir Password</h2>
            <p class="text-gray-600 text-center mb-6">Insira seu e-mail abaixo para receber o link de redefinição da password.</p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4" id="resetPasswordForm">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="E-mail" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-500" required>
                </div>
                <button type="submit" class="loading-button w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300" id="submitButton">
                    Enviar Link de Redefinição da Password
                </button>
                <!-- Barra de loading -->
                <div id="loadingBar" class="loading-bar" style="display: none;"></div>
            </form>
            <p class="text-center text-sm text-gray-600 mt-6">
                Lembrou-se da sua Password? <a href="{{ route('home') }}" class="text-link">Faça login</a>.
            </p>
        </div>
    </div>

    <!-- Pop-up de erro -->
    <div class="popup" id="errorPopup">
        <div class="popup-header">Erro</div>
        <div id="errorMessage">Mensagem de erro aqui.</div>
        <button class="popup-button" id="closePopup">Fechar</button>
    </div>

    <!-- Pop-up de sucesso -->
    <div class="popup popup-success" id="successPopup">
        <div class="popup-header">Sucesso</div>
        <div id="successMessage">O e-mail de redefinição foi enviado com sucesso!</div>
        <button class="popup-button" id="goHomeButton">Voltar para o Login!</button>
    </div>

    <script>
        const errorPopup = document.getElementById('errorPopup');
        const errorMessage = document.getElementById('errorMessage');
        const closePopup = document.getElementById('closePopup');
        const successPopup = document.getElementById('successPopup');
        const successMessage = document.getElementById('successMessage');
        const goHomeButton = document.getElementById('goHomeButton');
        const submitButton = document.getElementById('submitButton');
        const loadingBar = document.getElementById('loadingBar');

        // Exibir mensagem de erro se houver
        @if ($errors->any())
            errorMessage.innerText = '{{ $errors->first() }}';
            errorPopup.style.display = 'block';
        @endif

        // Verificar se a mensagem de sucesso existe na sessão
        @if (session('status'))
            successMessage.innerText = '{{ session('status') }}';
            successPopup.style.display = 'block'; // Exibe a pop-up de sucesso
        @endif

        closePopup.addEventListener('click', function() {
            errorPopup.style.display = 'none';
        });

        // Exibir barra de loading ao enviar o formulário
        document.getElementById('resetPasswordForm').addEventListener('submit', function() {
            loadingBar.style.display = 'block'; // Mostra a barra de loading
            submitButton.disabled = true; // Desativa o botão enquanto o formulário está sendo enviado
        });

        // Redirecionar para a página inicial
        goHomeButton.addEventListener('click', function() {
            window.location.href = '{{ route('home') }}';
        });
    </script>
</body>
</html>
