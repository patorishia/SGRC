<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SGRC')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<!-- jQuery (necessário para o DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


    <!-- Vite ou Laravel Mix CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        
        /* Sidebar fixa */
        .main-sidebar {
            position: fixed;
            top: 0; /* Fixa no topo */
            left: 0; /* Largura da sidebar a partir do lado esquerdo */
            bottom: 0; /* Até o fundo da tela */
            width: 250px; /* Largura fixa da sidebar */
            z-index: 1020; /* Certifique-se de que a sidebar esteja acima do conteúdo */
            overflow-y: auto; /* Para garantir que o conteúdo da sidebar não ultrapasse a altura da tela */
            height: 100vh; /* A sidebar vai ocupar toda a altura da tela */
        }

        /* Para garantir que o conteúdo da página não se sobreponha à sidebar */
        .content-wrapper {
            margin-left: 250px; /* Espaço para a sidebar fixa */
            padding-bottom: 60px; /* Espaço para o footer fixo */
            min-height: calc(100vh - 60px); /* Garante que o conteúdo principal tenha altura suficiente */
        }

        /* Footer fixo e ocupa toda a largura da tela */
        .main-footer {
            position: fixed;
            bottom: 0;
            left: 0; /* Alinha ao lado esquerdo da tela */
            right: 0; /* Alinha ao lado direito da tela */
            z-index: 1030; /* Para garantir que o footer fique acima do conteúdo */
            width: 100%; /* O footer vai ocupar toda a largura da tela */
            padding: 10px 0; /* Espaçamento interno do footer */
            background-color: #f1f1f1; /* Cor de fundo para o footer */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Cabeçalho -->
        <header class="main-header">
            <nav class="navbar navbar-expand navbar-white navbar-light">
                <div class="container-fluid">
                    <a  class="nav-link">{{ $pageTitle ?? 'Dashboard' }}</a>
                    <div class="navbar-nav ml-auto">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link nav-link" style="border: none; background: none; cursor: pointer;">
            <span class="brand-text font-weight-light">Desconectar</span>
        </button>
    </form>
</div>

                </div>
            </nav>
        </header>

        <!-- Barra Lateral -->
        @include('layouts.partials.sidebar')

        <!-- Conteúdo Principal -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Rodapé -->
        @include('layouts.partials.footer')
    </div>

    <script src="{{ asset('vendor/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
