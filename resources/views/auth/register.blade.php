<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Registo') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styles omitidos para brevidade */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>{{ __('Registo') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="{{ __('Nome') }}" autofocus>
                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('E-mail') }}">
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input type="password" id="password" name="password" required placeholder="{{ __('Senha') }}">
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="{{ __('Confirmar Senha') }}">
                @error('password_confirmation')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="loading-button w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                    {{ __('Entrar') }}
                </button>

            <a href="{{ route('home') }}">{{ __('Já tem uma conta? Faça login') }}</a>
        </form>
    </div>
</body>
</html>

