<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Verificação de E-mail') }}</title>
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
        }

        .description {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6B7280;
        }

        .logout-button {
            text-align: right;
        }

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
<div style="position: absolute; top: 10px; right: 10px;">
    <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
        @csrf
        <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
            <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>{{ __('Português (Portugal)') }}</option>
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('English (US)') }}</option>
            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français (France)</option>
        </select>
    </form>
</div>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="card">
        <!-- Título e texto explicativo -->
        <h2 class="title">{{ __('Aguarde a verificação do seu E-mail!') }}</h2>
        <p class="description">
            {{ __('Obrigado por se registar no nosso site! Para continuar por favor, espere que o nosso administrador verifique a sua conta. Uma vez feito, receberá um email!') }}
        </p>

        <!-- Formulário de logout -->
        <div class="logout-button mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    {{ __('Sair') }}
                </button>
            </form>
        </div>
    </div>

</body>
</html>
