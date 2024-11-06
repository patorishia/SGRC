<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg max-w-2xl w-full flex text-gray-800">
        <!-- Formulário de redefinição de senha -->
        <div class="w-full p-8">
            <h2 class="text-2xl font-semibold text-center mb-4">Redefinir Senha</h2>
            <p class="text-gray-600 text-center mb-6">Insira uma nova palavra passe para a sua conta.</p>

            <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                    <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                    <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                        Redefinir
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        .loading-button {
            position: relative;
            width: 100%;
            background-image: linear-gradient(to top right, #4f46e5, #4f46e5); 
            color: white;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: block;
            text-align: center;
        }

        .loading-button:hover {
            background-image: linear-gradient(to top right, #6b6ef0, #4f46e5);
        }
    </style>

</body>
</html>
