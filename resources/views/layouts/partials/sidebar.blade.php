
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo do Sistema -->
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name', 'SGRC') }}</span>
    </a>
    
    <div class="sidebar">
        <!-- Área do Usuário -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('path/to/user-image.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ __('Bem-vindo') }}, {{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Menu de Navegação -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Painel de Controlo') }}</p>
                    </a>
                </li>
                
                <!-- Condominios -->
                <li class="nav-item">
                    <a href="{{ route('condominios.index') }}" class="nav-link {{ request()->routeIs('condominios.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>{{ __('Condomínios') }}</p>
                    </a>
                </li>
                
                <!-- Condóminos -->
                <li class="nav-item">
                    <a href="{{ route('condominos.index') }}" class="nav-link {{ request()->routeIs('condominos.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('Condóminos') }}</p>
                    </a>
                </li>
                
                <!-- Reclamações -->
                <li class="nav-item">
                    <a href="{{ route('reclamacoes.index') }}" class="nav-link {{ request()->routeIs('reclamacoes.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exclamation-triangle"></i>
                        <p>{{ __('Reclamações') }}</p>
                    </a>
                </li>

                <!-- Tipos de Reclamação -->
                <li class="nav-item">
                    <a href="{{ route('tipos_reclamacao.index') }}" class="nav-link {{ request()->routeIs('tipos_reclamacao.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>{{ __('Tipos de Reclamação') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
