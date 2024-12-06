<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

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
        /* Customização do Dropdown de Idioma */
        #switch-language {
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Cabeçalho -->
        <header class="main-header">
            <nav class="navbar navbar-expand navbar-white navbar-light">
                <div class="container-fluid">
                    <a class="nav-link">{{ $pageTitle ?? 'Dashboard' }}</a>
                    <div class="navbar-nav ml-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="border: none; background: none; cursor: pointer;">
                                <span class="brand-text font-weight-light">{{__('Desconectar')}}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Barra Lateral -->
        @include('layouts.partials.sidebar')

        <!-- Seleção de Idioma -->
        <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
            @csrf
            <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
                <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>Português (Portugal)</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English (US)</option>
            </select>
        </form>

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
