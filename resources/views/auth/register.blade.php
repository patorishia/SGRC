<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('build/assets/bg2.jpg') }}');
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

        .form-container input {
            width: 100%;
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
<body>
    <div class="form-container">
        <h2>Registro</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nome" autofocus>
                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="E-mail">
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input type="password" id="password" name="password" required placeholder="Senha">
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirmar Senha">
                @error('password_confirmation')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="loading-button w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                    Entrar
                </button>

            <a href="{{ route('home') }}">Já tem uma conta? Faça login.</a>
        </form>
    </div>
</body>
</html>
