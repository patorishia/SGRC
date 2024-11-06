<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('build/assets/bg2.jpg') }}'); /* Substitua pelo caminho da sua imagem de fundo */
            background-size: cover; /* Faz com que a imagem cubra toda a área do fundo */
            background-position: center; /* Centraliza a imagem de fundo */
            min-height: 100vh; /* Garante que a altura mínima seja 100% da altura da tela */
            display: flex;
            align-items: center; /* Centraliza verticalmente */
            justify-content: center; /* Centraliza horizontalmente */
        }
/* Estilo do pop-up */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Fica acima de outros elementos */
            display: none; /* Oculto por padrão */
        }

        .popup-header {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .popup-button {
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5); /* Gradiente do botão */
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block; /* Faz o botão ocupar a largura necessária */
            margin: 0 auto; /* Centraliza o botão */
        }

        .popup-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5); /* Efeito de hover no botão */
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Mantém as bordas arredondadas */
            border-top-left-radius: 0.5rem; /* Bordas arredondadas */
            border-bottom-left-radius: 0.5rem; /* Bordas arredondadas */
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .slider img {
            width: 100%;
            height: auto;
            object-fit: cover; /* Faz com que a imagem cubra toda a área do slide */
        }

        .bg-blue {
            border-top-left-radius: 0.5rem; /* Bordas arredondadas */
            border-bottom-left-radius: 0.5rem; /* Bordas arredondadas */
        }

        .text-overlay {
            position: absolute;
            color: white;
            text-align: center;
            width: 100%;
            bottom: 20%; /* Ajuste para posicionar o texto na parte inferior */
        }

        /* Estilo das bolinhas de navegação */
        .nav-dots {
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: 10px; /* Ajuste para posicionar as bolinhas no topo */
            left: 50%;
            transform: translateX(-50%); /* Centraliza as bolinhas horizontalmente */
            z-index: 10; /* Garante que as bolinhas fiquem acima da imagem */
        }

        .dot {
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            opacity: 0.5; /* Opacidade padrão das bolinhas */
            transition: opacity 0.3s;
        }

        .dot.active {
            opacity: 1; /* Bolinha ativa com opacidade total */
        }

        .loading-button {
            position: relative;
            overflow: hidden; /* Oculta a barra de loading quando não está em uso */
            transition: transform 0.3s ease; /* Transição para o efeito de escala */
        }

        .loading-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.5); /* Cor da barra de loading */
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .loading {
            pointer-events: none; /* Desativa eventos de clique enquanto carrega */
        }

        /* Nova classe para os links */
        .text-link {
            color: #4f46e5; /* Cor azul do botão */
            transition: color 0.3s ease; /* Efeito de transição suave */
        }

        .text-link:hover {
            color: #3b82f6; /* Efeito de hover, cor mais clara */
        }
    </style>
</head>
<body>
    <div class="bg-blue-500 shadow-lg rounded-lg max-w-2xl w-full flex text-white">
        <!-- Slider de imagens -->
        <div class="w-1/2 p-0 flex flex-col justify-center items-center relative bg-blue">
            <div class="slider-container">
                <div class="slider" id="imageSlider">
                    <img src="{{ asset('build/assets/1.png') }}" alt="Imagem 1">
                    <img src="{{ asset('build/assets/2.png') }}" alt="Imagem 2">
                    <img src="{{ asset('build/assets/3.png') }}" alt="Imagem 3">
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
            <h2 class="text-2xl font-semibold text-center mb-4">Login</h2>
            <p class="text-gray-600 text-center mb-6">Bem-vindo ao nosso sistema de gestão de reclamações. Você pode registrar e acompanhar suas reclamações de forma fácil e eficiente. Estamos aqui para ajudar!</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="E-mail" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Palavra-passe" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                </div>
                <div class="flex items-center justify-between">
                    <a href="{{ route('password.request') }}" class="text-sm text-link">Esqueceste-te da palavra-passe?</a>
                </div>
                <button type="submit" class="loading-button w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                    Entrar
                    <div class="loading-bar"></div> <!-- Barra de carregamento -->
                </button>
            </form>
            <p class="text-center text-sm text-gray-600 mt-6">
                Ainda não tens uma conta? <a href="{{ route('register') }}" class="text-link">Cria a tua conta gratuitamente</a>.
            </p>
        </div>
    </div>

    <!-- Pop-up para mensagens de erro -->
    <div class="popup" id="errorPopup">
        <div class="popup-header">Erro no Login</div>
        <div id="errorMessage">Mensagem de erro aqui.</div>
        <button class="popup-button" id="closePopup">Fechar</button>
    </div>


    <script>
        let currentIndex = 0;
        const slider = document.getElementById('imageSlider');
        const images = slider.children;
        const totalImages = images.length;
        const dots = document.querySelectorAll('.dot');

        function slideImages() {
            currentIndex = (currentIndex + 1) % totalImages;
            updateSlider();
        }

        function goToSlide(index) {
            currentIndex = index;
            updateSlider();
        }

        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        setInterval(slideImages, 5000); // Muda de imagem a cada 5 segundos

        const loginForm = document.getElementById('loginForm');
        const button = loginForm.querySelector('button');
        const loadingBar = button.querySelector('.loading-bar');
        const errorPopup = document.getElementById('errorPopup');
        const errorMessage = document.getElementById('errorMessage');
        const closePopup = document.getElementById('closePopup');

        // Verifica se há erros de login
        @if ($errors->any())
        errorMessage.innerText = '{{ $errors->first() }}'; // Mensagem do primeiro erro
        errorPopup.style.display = 'block'; // Exibe o pop-up
        @endif


        loginForm.addEventListener('submit', function(event) {
            button.classList.add('loading'); // Adiciona a classe de loading
            loadingBar.style.transform = 'translateX(0)'; // Move a barra de loading para mostrar

            // O formulário é enviado imediatamente, não há necessidade de preventDefault()
            // O botão será desativado apenas para evitar cliques múltiplos
            button.disabled = true; // Desativa o botão para evitar múltiplos envios
        });

        // Efeito de animação no botão ao ser pressionado
        button.addEventListener('mousedown', function() {
            button.style.transform = 'scale(0.95)'; // Efeito de diminuição
        });

        button.addEventListener('mouseup', function() {
            button.style.transform = 'scale(1)'; // Retorna ao tamanho original
        });

        button.addEventListener('mouseleave', function() {
            button.style.transform = 'scale(1)'; // Retorna ao tamanho original se sair
        });

        // Fecha o pop-up
        closePopup.addEventListener('click', function() {
            errorPopup.style.display = 'none'; // Oculta o pop-up
        });
    </script>
</body>
</html>