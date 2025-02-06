<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Reclamação Atualizada') }}</title>
</head>
<body>
    <p>{{ __('A reclamação') }}: <strong>{{ $reclamacaoId }}</strong>, {{ __('do condomínio') }} <strong>{{ $condominioName }}</strong> {{ __('foi atualizada!') }}</p>
    <p>{{ __('Veja mais detalhes da reclamação no link:') }} <a href="{{ $reclamacaoUrl }}">{{ __('Clique aqui') }}</a></p>
</body>
</html>
