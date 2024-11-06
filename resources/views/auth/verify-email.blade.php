<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg max-w-md w-full flex flex-col p-8">
        <!-- Título e texto explicativo -->
        <h2 class="text-2xl font-semibold text-center mb-4">Verifique o seu E-mail!</h2>
        <p class="text-gray-600 text-center mb-6">Obrigador por se registar no nosso site! Para continuar por favor, clique no link enviado para o seu e-mail para confirmar sua conta. Se não recebeu nenhum email, clique no botão para reenviar!</p>

        <!-- Formulário para reenvio de e-mail de verificação -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-tr from-indigo-100 to-indigo-900 hover:bg-gradient-to-tr hover:from-indigo-200 hover:to-indigo-800 text-white font-semibold py-3 rounded-md transition duration-300">
                Reenviar E-mail de Verificação
            </button>
        </form>

        <!-- Formulário de logout -->
        <div class="flex justify-end mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sair
                </button>
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
    </style>

</body>
</html>
