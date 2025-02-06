<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Conta Verificada') }}</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>{{ __('Olá, :name!', ['name' => $name]) }}</h1>  

    <p>{{ __('A sua conta foi verificada com sucesso e agora pode aceder ao nosso site.') }}</p>

    <p>{{ __('Obrigado por se registar!') }}</p>

    
    <a href="https://sgrc.infinityfreeapp.com" class="button">{{ __('Ir para o site') }}</a>
</body>
</html>
