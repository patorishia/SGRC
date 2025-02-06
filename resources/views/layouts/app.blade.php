<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SGRC')</title>

    <!-- CSS do AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">

    <!-- Font Awesome (para ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS do DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <style>
    /* Cor base para o cabeçalho */
    .main-header {
        background-color: #17a2b8;  /* Azul esverdeado para o cabeçalho */
    }

    .main-header .navbar {
        background-color: #17a2b8;  /* Garantir que a barra de navegação também use a mesma cor */
    }

    /* Ajuste para o link da marca (logotipo) */
    .brand-link {
        background-color: #117a8b;  /* Azul mais escuro para contraste */
        color: #fff;  /* Texto branco */
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        text-align: center;
    }

    /* Garantir que o logotipo permaneça visível no estado recolhido */
    .main-sidebar.collapsed .brand-link {
        display: block;
        text-align: center;
        background-color: #117a8b;
    }

    /* Opcionalmente, ocultar o logotipo quando a barra lateral estiver recolhida */
    .main-sidebar.collapsed .brand-logo {
        display: none;
    }

    .brand-logo .logo-img {
        max-width: 100%;
        height: auto;
        width: auto;
    }

    /* Ajustes para os itens da barra de navegação */
    .navbar-nav.ml-auto {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar-nav .nav-item {
        margin-left: 15px;
    }

    .navbar-nav .nav-link {
        padding: 8px 15px;
    }

    /* Alterar a cor do ícone do botão de colapso da barra lateral para branco */
    .sidebar .nav-link i {
        color: #fff !important;
    }

    .main-sidebar .nav-link i {
        color: #fff !important;
    }

    /* Estilização da imagem de perfil */
    .navbar-nav .nav-item .nav-link img {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    /* Botão de configurações e barra lateral direita */
    #settings-button {
        cursor: pointer;
        font-size: 20px;
        margin-left: 15px;
    }

    /* Barra lateral de configurações (desliza horizontalmente) */
    .settings-sidebar {
        position: fixed;
        top: 0;
        right: -250px; /* Começa fora da tela */
        width: 250px;
        height: 100%; /* Ocupa toda a altura da tela */
        background-color: #333;
        color: white;
        margin-top: 55px;
        padding: 20px;
        display: block;
        transition: right 0.5s ease-in-out; /* Transição suave ao deslizar */
        z-index: 9999;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        overflow-y: auto; /* Permitir rolagem vertical */
    }

    .settings-sidebar ul {
        list-style: none;
        padding: 0;
    }

    .settings-sidebar li {
        margin: 10px 0;
    }

    .settings-sidebar .color-option {
        display: block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 5px 0;
        cursor: pointer;
    }

    /* Alterar a cor dos ícones do cabeçalho para branco */
    .navbar-nav .nav-link i {
        color: #fff !important;
    }

    #settings-button i {
        color: #fff !important;
    }

    /* Alterar a cor do ícone de logout para branco */
    .nav-item .nav-link i {
        color: #fff !important;
    }

    /* Opções de tema na barra lateral */
    .settings-sidebar .theme-option {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        width: 100%;
        margin-bottom: 20px;
    }

    .settings-sidebar .theme-option img.theme-image {
        width: 60%;
        max-width: 150px;
        height: auto;
        border-radius: 5px;
    }

    .settings-sidebar .theme-option p {
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
    }

    </style>

</head>

<body class="hold-transition sidebar-mini">
    
    <div class="wrapper">
        <!-- Cabeçalho Principal -->
        <header class="main-header">
            <nav class="navbar navbar-expand navbar-light navbar-white">
                <div class="container-fluid">
                    <!-- Botão para alternar a barra lateral -->
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars" style="color: white;"></i>
                </a>

                    <!-- Links da barra de navegação -->
                    <div class="navbar-nav ml-auto">
                    <div class="dropdown">
    <button class="btn btn-link dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-globe" style="color: white;"></i> <!-- Ícone do globo com cor branca -->
    </button>
    <div class="dropdown-menu" aria-labelledby="languageDropdown">
        <form action="{{ url('set-locale') }}" method="POST">
            @csrf
            <input type="hidden" name="locale" id="selectedLocale">
            <a class="dropdown-item" href="#" onclick="changeLocale('pt')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Flag_of_Portugal.svg" alt="Bandeira de Portugal" width="20" class="mr-2">
                Português (Portugal)
            </a>
            <a class="dropdown-item" href="#" onclick="changeLocale('en')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Flag_of_the_United_States.svg" alt="Bandeira dos EUA" width="20" class="mr-2">
                English (US)
            </a>
            <a class="dropdown-item" href="#" onclick="changeLocale('fr')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Flag_of_France.svg" alt="Bandeira da França" width="20" class="mr-2">
                Français (France)
            </a>
        </form>
    </div>
</div>



                       <!-- Botão de Configurações -->
                       <div id="settings-button">
                            <i class="fas fa-cogs"></i>
                        </div>

                        <!-- Botão de Logout -->
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="color: #333; text-decoration: none;">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                </button>
                            </form>
                        </li>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Barra Lateral (Movida para baixo do cabeçalho) -->
        <aside class="main-sidebar">
            @include('layouts.partials.sidebar')
        </aside>

        <!-- Conteúdo Principal -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Rodapé -->
        @include('layouts.partials.footer')
    </div>


   <!-- Barra Lateral de Configurações -->
   <div class="settings-sidebar">
    <h3>{{ __('Mudar Tema ') }}</h3>
    <ul class="theme-options">
        <li class="theme-option">
            <img src="images/yellow.png" alt="Amarelo" class="theme-image" data-header-color="#f39c12" data-sidebar-color="#8a6d3b">
            <p>{{ __('Amarelo') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/red.png" alt="Vermelho" class="theme-image" data-header-color="#dd4b39" data-sidebar-color="#7e2a25">
            <p>{{ __('Vermelho') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/green.png" alt="Verde" class="theme-image" data-header-color="#00a65a" data-sidebar-color="#1b4d3e">
            <p>{{ __('Verde') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/blue.png" alt="Azul" class="theme-image" data-header-color="#007bff" data-sidebar-color="#0056b3">
            <p>{{ __('Azul') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/violet.png" alt="Violeta" class="theme-image" data-header-color="#6f42c1" data-sidebar-color="#4e2883">
            <p>{{ __('Violeta') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/teal.png" alt="Verde Azulado" class="theme-image" data-header-color="#17a2b8" data-sidebar-color="#117a8b">
            <p>{{ __('Verde azulado') }}</p>
        </li>
        <li class="theme-option">
            <img src="images/gray.png" alt="Cinza" class="theme-image" data-header-color="#6c757d"data-sidebar-color="#343a40">
            <p>{{ __('Cinza') }}</p>
        </li>
    </ul>
</div>
<!-- jQuery (necessário para dropdowns do Bootstrap e DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (necessário para dropdowns e outros componentes do Bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>

    <script>
        // Verifica se uma cor de tema está salva no localStorage
        $(document).ready(function() {
            var headerColor = localStorage.getItem('header-color');
            var sidebarColor = localStorage.getItem('sidebar-color');

            if (headerColor && sidebarColor) {
                // Aplica as cores salvas
                $('.main-header').css('background-color', headerColor);
                $('.main-header .navbar').css('background-color', headerColor);
                $('.main-header .navbar').css('color', '#000');
                $('.brand-link').css('background-color', sidebarColor);
            }
        });

        // Abrir e fechar a barra lateral de configurações com efeito de deslize horizontal
        $('#settings-button').on('click', function () {
            var sidebar = $('.settings-sidebar');
            var isVisible = sidebar.css('right') === '0px';
            sidebar.css('right', isVisible ? '-250px' : '0');
        });

        // Alterar cores do cabeçalho e da barra lateral
        $('.color-option').on('click', function () {
            var headerColor = $(this).data('header-color');
            var sidebarColor = $(this).data('sidebar-color');

            // Alterar cor do cabeçalho
            $('.main-header').css('background-color', headerColor);

            // Alterar cor da navbar para melhor contraste
            $('.main-header .navbar').css('background-color', headerColor);
            $('.main-header .navbar').css('color', '#000');

            // Alterar somente a cor do link da marca na barra lateral
            $('.brand-link').css('background-color', sidebarColor);

            // Salvar as cores selecionadas no localStorage
            localStorage.setItem('header-color', headerColor);
            localStorage.setItem('sidebar-color', sidebarColor);
        });

        // Alterar cores do cabeçalho e da barra lateral ao clicar na imagem do tema
        $('.theme-image').on('click', function () {
            var headerColor = $(this).data('header-color');
            var sidebarColor = $(this).data('sidebar-color');

            $('.main-header').css('background-color', headerColor);
            $('.main-header .navbar').css('background-color', headerColor);
            $('.main-header .navbar').css('color', '#000');
            $('.brand-link').css('background-color', sidebarColor);

            localStorage.setItem('header-color', headerColor);
            localStorage.setItem('sidebar-color', sidebarColor);
        });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    //Função para mudar de linguagem
     function changeLocale(locale) {
            document.getElementById('selectedLocale').value = locale;
            document.querySelector('form').submit();
        }
</script>

</body>

</html>
