<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Verificação de Condomino')}}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Liga o CSS da aplicação -->
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Liga o JavaScript da aplicação -->
    <style>
        /* Estilos do fundo da página */
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
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #16a34a; /* Cor verde para sucesso */
        }

        .description {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6B7280;
        }

        /* Estilo do botão de logout */
        .logout-button button {
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5);
            color: white;
            padding: 0.75rem;
            width: 100%;
            text-align: center;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="title">{{__('Condomínio verificado com sucesso!')}}</h2> <!-- Título de sucesso -->
        <p class="description">{{__('O utilizador foi verificado e pode agora acessar a plataforma.')}}</p> <!-- Descrição da verificação bem-sucedida -->

        <!-- Formulário de logout -->
        <div class="logout-button mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf <!-- Proteção contra CSRF -->
                <button type="submit">
                    {{ __('Sair') }} <!-- Botão de logout -->
                </button>
            </form>
        </div>
    </div>
</body>
</html>
