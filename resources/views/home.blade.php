<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Entrar') }}</title>
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
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            display: flex;
            overflow: hidden;
        }

        .slider-container {
            position: relative;
            width: 50%;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-form {
            width: 50%;
            padding: 2rem;
            margin-right: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-form h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .login-form p {
            color: #555;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .login-form input {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .login-form button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 1.1rem;
            border: none;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        .dots-container {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .dot {
            width: 10px;
            height: 10px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dot.active {
            background-color: white;
        }
    </style>
</head>
<div style="position: absolute; top: 10px; right: 10px;">
    <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
        @csrf
        <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
            <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>{{ __('Português (Portugal)') }}
            </option>
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('English (US)') }}</option>
            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français (France)</option>
        </select>
    </form>
</div>

<body>
    <div class="card">
        <div class="slider-container">
            <!-- Slider de imagens -->
            <div class="slider" id="imageSlider">
                <!-- Imagens do slider -->
                <img src="{{ asset('images/1.png') }}" alt="{{ __('Imagem 1') }}">
                <img src="{{ asset('images/2.png') }}" alt="{{ __('Imagem 2') }}">
                <img src="{{ asset('images/3.png') }}" alt="{{ __('Imagem 3') }}">
            </div>

            <!-- Contêiner dos pontos (indicadores) do slider -->
            <div class="dots-container" id="dotsContainer">
                <!-- Os pontos serão gerados dinamicamente aqui -->
            </div>
        </div>

        <!-- Formulário de login -->
        <div class="login-form">
            <h2 class="text-2xl font-semibold">{{ __('Login') }}</h2>
            <p>{{ __('Bem-vindo ao nosso sistema de gestão de reclamações. Faça login para continuar.') }}</p>
            <!-- Formulário de login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Campo de e-mail -->
                <input type="email" name="email" placeholder="{{ __('E-mail') }}" required>
                <!-- Campo de palavra-passe -->
                <input type="password" name="password" placeholder="{{ __('Palavra-passe') }}" required class="mb-1">

                <!-- Link para recuperação de palavra-passe -->
                <p class="text-sm text-right mt-1">
                    <a href="{{ route('password.request') }}"
                        class="text-blue-500">{{ __('Esqueci-me da palavra-passe') }}</a>
                </p>

                <!-- Botão de login -->
                <button type="submit">{{ __('Login') }}</button>
            </form>

            <!-- Link para registo de uma nova conta -->
            <p class="text-sm mt-6">
                {{ __('Ainda não tens uma conta?') }} <br>
                <a href="{{ route('register') }}" class="text-blue-500">{{ __('Cria a tua conta gratuitamente') }}</a>.
            </p>
        </div>
    </div>

    <script>
        // Variáveis para controlar o índice da imagem atual
        let currentIndex = 0;
        const images = document.querySelectorAll('#imageSlider img'); // Seleciona todas as imagens
        const totalImages = images.length; // Número total de imagens
        const dotsContainer = document.getElementById('dotsContainer'); // Contêiner dos pontos (indicadores)

        // Cria os pontos dinamicamente com base no número de imagens
        for (let i = 0; i < totalImages; i++) {
            const dot = document.createElement('div'); // Cria um novo ponto
            dot.classList.add('dot'); // Adiciona a classe 'dot' para estilo
            dot.addEventListener('click', () => showSlide(i)); // Define a ação ao clicar no ponto (exibir imagem correspondente)
            dotsContainer.appendChild(dot); // Adiciona o ponto ao contêiner
        }

        // Função para alterar a imagem do slider
        function changeSlide() {
            currentIndex = (currentIndex + 1) % totalImages; // Incrementa o índice da imagem e faz loop quando atinge o fim
            showSlide(currentIndex); // Exibe a imagem correspondente
        }

        // Função para mostrar uma imagem específica com base no índice
        function showSlide(index) {
            currentIndex = index; // Atualiza o índice da imagem atual
            document.getElementById('imageSlider').style.transform = `translateX(-${currentIndex * 100}%)`; // Desloca o slider para a imagem desejada

            // Atualiza o ponto ativo
            const dots = document.querySelectorAll('.dot'); // Seleciona todos os pontos
            dots.forEach(dot => dot.classList.remove('active')); // Remove a classe 'active' de todos os pontos
            dots[currentIndex].classList.add('active'); // Adiciona a classe 'active' ao ponto atual
        }

        // Altera a imagem automaticamente a cada 3 segundos
        setInterval(changeSlide, 3000);

        // Inicializa o slider com a primeira imagem
        showSlide(currentIndex);
    </script>
</body>

</html>