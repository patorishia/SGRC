<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo do Sistema -->
    <a href="#" class="brand-link">
    <span class="brand-text">SGRC</span>
</a>

    
    <div class="sidebar">
        <!-- Área do User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ Auth::user()->profileImage ? asset('storage/profileImages/' . Auth::user()->profileImage) : asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image" style="width: 50px; height: 50px; object-fit: cover;">
    </div>
    <div class="info">
        <a href="{{ route('profile.edit') }}" class="d-block">{{ __('Bem-vindo') }}, {{ Auth::user()->name }}</a>
    </div>
</div>



        <!-- Menu de Navegação -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Painel de Controlo') }}</p>
                    </a>
                </li>
                @endif
                
                <!-- Meus Condominios (User) -->
                @if(Auth::user()->role == 'admin' || \App\Models\Condominio::where('manager_id', Auth::id())->exists())
                    <li class="nav-item">
                        <a href="{{ route('condominios.meus') }}" class="nav-link {{ request()->routeIs('condominios.meus') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>{{ __('Gerir Condominios') }}</p>
                        </a>
                    </li>
                @endif
                                <!-- Condominios (Admin) -->
                <li class="nav-item">
                    <a href="{{ route('condominios.index') }}" class="nav-link {{ request()->routeIs('condominios.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>{{ __('Condomínios') }}</p>
                    </a>
                </li>
                
                @if(Auth::user()->role == 'admin' || \App\Models\Condominio::where('manager_id', Auth::id())->exists())
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('Condóminos') }}</p>
                    </a>
                </li>
                @endif
                
                <!-- Reclamações (Admin) -->
                @if(Auth::user()->role == 'admin' || \App\Models\Condominio::where('manager_id', Auth::id())->exists())
                <li class="nav-item">
                    <a href="{{ route('reclamacoes.index') }}" class="nav-link {{ request()->routeIs('reclamacoes.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exclamation-triangle"></i>
                        <p>{{ __('Reclamações') }}</p>
                    </a>
                </li>
                @endif

                <!-- Tipos de Reclamação (Admin) -->
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('tipos_reclamacao.index') }}" class="nav-link {{ request()->routeIs('tipos_reclamacao.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>{{ __('Tipos de Reclamação') }}</p>
                    </a>
                </li>
                @endif

                <!-- Produtos (Admin) -->
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('produtos.index') }}" class="nav-link {{ request()->routeIs('produtos.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>{{ __('Produtos / Renda') }}</p>
                    </a>
                </li>
                @endif

                <!-- Faturas (Admin) -->
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('faturas.index') }}" class="nav-link {{ request()->routeIs('faturas.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>{{ __('Faturas') }}</p>
                    </a>
                </li>
                @endif

                <!-- Clientes (Admin) -->
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('Clientes') }}</p>
                    </a>
                </li>
                @endif

                <!-- Minhas Reclamações (User) -->
                @if(Auth::user()->role == 'user')
                <li class="nav-item">
                    <a href="{{ route('reclamacoes.minhas') }}" class="nav-link {{ request()->routeIs('reclamacoes.minhas') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>{{ __('Minhas Reclamações') }}</p>
                    </a>
                </li>
                @endif

                 <!-- Minhas Faturas (User) -->
                @if(Auth::user()->role == 'user')
                <li class="nav-item">
                    <a href="{{ route('faturas.minhas') }}" class="nav-link {{ request()->routeIs('faturas.minhas') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-invoice"></i>
                        <p>{{ __('Minhas Faturas') }}</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>

    <a href="#" class="brand-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
        </a>
    
</aside>

