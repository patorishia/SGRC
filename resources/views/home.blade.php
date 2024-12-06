<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Entrar') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* CSS styles remain unchanged */
    </style>
</head>
<body>
    <div class="bg-blue-500 shadow-lg rounded-lg max-w-2xl w-full flex text-white">
        <!-- Slider de imagens -->
        <div class="w-1/2 p-0 flex flex-col justify-center items-center relative bg-blue">
            <div class="slider-container">
                <div class="slider" id="imageSlider">
                    <img src="{{ asset('build/assets/1.png') }}" alt="{{ __('Imagem 1') }}">
                    <img src="{{ asset('build/assets/2.png') }}" alt="{{ __('Imagem 2') }}">
                    <img src="{{ asset('build/assets/3.png') }}" alt="{{ __('Imagem 3') }}">
                </div>
                <!-- Bolinhas de navegação -->
                <div class="nav-dots">
                    <span class="dot active" onclick="goToSlide(0)"></span>
                    <span class="dot" onclick="goToSlide(1)"></span>
                    <span class="dot" onclick="goToSlide(2)"></span>
                </div>
            </div>
        </div>

        <!-- Formulário de login -->
        <div class="w-1/2 bg-white rounded-r-lg p-8 text-gray-800">
            <h2 class="text-2xl font-semibold text-center mb-4">{{ __('Login') }}</h2>
            <p class="text-gray-600 text-center mb-6">{{ __('Bem-vindo ao nosso sistema de gestão de reclamações. Você pode registrar e acompanhar suas reclamações de forma fácil e eficiente. Estamos aqui para ajudar!') }}</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="{{ __('E-mail') }}" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="{{ __('Palavra-passe') }}" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                </div>
                <div class="flex items-center justify-between">
                    <a href="{{ route('password.request') }}" class="text-sm text-link">{{ __('Esqueceste-te da palavra-passe?') }}</a>
                </div>
                <button type="submit" class="loading-button w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                    {{ __('Entrar') }}
                    <div class="loading-bar"></div> <!-- Barra de carregamento -->
                </button>
            </form>
            <p class="text-center text-sm text-gray-600 mt-6">
                {{ __('Ainda não tens uma conta?') }} <a href="{{ route('register') }}" class="text-link">{{ __('Cria a tua conta gratuitamente') }}</a>.
            </p>
        </div>
    </div>

    <!-- Pop-up para mensagens de erro -->
    <div class="popup" id="errorPopup">
        <div class="popup-header">{{ __('Erro ao Iniciar Sessão') }}</div>
        <div id="errorMessage">{{ __('Mensagem de erro aqui.') }}</div>
        <button class="popup-button" id="closePopup">{{ __('Fechar') }}</button>
    </div>

    <script>
        // JavaScript remains unchanged
    </script>
</body>
</html>
