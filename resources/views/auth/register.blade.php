<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Registo') }}</title>
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

        .form-container {
            background-color: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-container input, .form-container select {
            width: 93%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }

        .form-container button {
            background-color: #4f46e5;
            color: white;
            padding: 0.75rem;
            width: 100%;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #3730a3;
        }

        .form-container a {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #4f46e5;
            text-decoration: none;
        }

        .form-container a:hover {
            color: #3730a3;
        }

        .input-error {
            color: #e53e3e;
            margin-top: 0.5rem;
        }
    </style>
</head>
<div style="position: absolute; top: 10px; right: 10px;">
    <form action="{{ url('set-locale') }}" method="POST" id="switch-language">
        @csrf
        <select name="locale" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
            <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>Português (Portugal)</option>
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English (US)</option>
            <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français (France)</option>
        </select>
    </form>
</div>

<body>
    <div class="form-container">
        
        <h2>{{ __('Registo') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="nif">{{ __('NIF') }}</label>
                <input type="text" id="nif" name="nif" value="{{ old('nif') }}" required placeholder="{{ __('NIF') }}">
                @error('nif')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
            <label for="nif">{{ __('Nome') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="{{ __('Nome') }}" autofocus>
                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('Email') }}">
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="telefone">{{ __('Telefone') }}</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" required placeholder="{{ __('Telefone') }}">
                @error('telefone')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
            <label for="nif">{{ __('Condomínio') }}</label>
                <select id="condominio_id" name="condominio_id" required>
                    <option value="">{{ __('Selecione o condomínio') }}</option>
                    @foreach($condominios as $condominio)
                        <option value="{{ $condominio->id }}" {{ old('condominio_id') == $condominio->id ? 'selected' : '' }}>{{ $condominio->nome }}</option>
                    @endforeach
                </select>
                @error('condominio_id')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
            <label for="nif">{{ __('palavra-passe') }}</label>
                <input type="password" id="password" name="password" required placeholder="{{ __('palavra-passe') }}">
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
            <label for="nif">{{ __('Confirmar palavra-passe') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="{{ __('Confirmar palavra-passe') }}">
                @error('password_confirmation')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">
                {{ __('Registar') }}
            </button>

            <a href="{{ route('login') }}">{{ __('Já tem uma conta? Faça login.') }}</a>
        </form>
    </div>
</body>
</html>
