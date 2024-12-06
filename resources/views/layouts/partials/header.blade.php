<header class="main-header navbar navbar-expand navbar-dark navbar-primary">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Nome da aplicação -->
            <a href="{{ url('/') }}" class="navbar-brand">
                <span class="brand-text font-weight-bold text-white">{{ config('app.name', 'SGRC') }}</span>
            </a>
            
            <!-- Barra de navegação -->
            <div class="navbar-nav ml-auto">
                <!-- Link para Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-link text-white">
                    <i class="fas fa-tachometer-alt mr-2"></i> {{ __('Painel de Controlo') }}
                </a>
                
                <!-- Imagem de perfil ou link de logout -->
                <a href="#" class="nav-link dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> {{ __('Bem-vindo') }}, {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Sair') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>
