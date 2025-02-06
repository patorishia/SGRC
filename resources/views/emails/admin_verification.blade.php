<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Novo registo') }}</title>
</head>
<body>
    <h1>{{ __('Um novo Condomino precisa de verificação.') }}</h1>

    <p><strong>{{ __('Nome:') }}</strong> {{ $user->name }}</p>
    <p><strong>{{ __('Email:') }}</strong> {{ $user->email }}</p>
    <p><strong>{{ __('NIF:') }}</strong> {{ $user->nif }}</p>
    <p><strong>{{ __('Telefone:') }}</strong> {{ $user->telefone }}</p>
    <p><strong>{{ __('Condomínio:') }}</strong> {{ $user->condominio->nome }}</p>

    <p>{{ __('Clique aqui para verificar condominio.') }}</p>
    <a href="{{ route('admin.verify', ['user' => $user->id]) }}" 
       style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px;">
       {{ __('Verificar Condomino.') }}
    </a>
</body>
</html>
