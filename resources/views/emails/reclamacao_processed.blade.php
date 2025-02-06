<!DOCTYPE html>
<html>
<head>
    <title>{{ __('A sua Reclamação está a ser Processada') }}</title>
</head>
<body>
    <h1>{{ __('A sua Reclamação está a ser processada') }}</h1>
    <p><strong>{{ __('ID da Reclamação:') }}</strong> {{ $reclamacao_id }}</p>
    <p><strong>{{ __('Condomínio:') }}</strong> {{ $condominio_name }}</p>
    <p><strong>{{ __('Estado Atual:') }}</strong> {{ $estado }}</p>
    <p>{{ __('Acompanhe o progresso da sua reclamação') }} <a href="{{ url('/reclamacoes/' . $reclamacao_id) }}">{{ __('aqui') }}</a>.</p>
</body>
</html>
