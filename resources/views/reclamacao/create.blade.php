<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Reclamação</title>
</head>

<body>
    <h1>Criar Reclamação</h1>
    <form action="{{ route('reclamacoes.store') }}" method="POST">
        @csrf

        <label for="tipo_reclamacao">Tipo de Reclamação</label>
        <select name="tipo_reclamacao_id" id="tipo_reclamacao" required>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
            @endforeach
        </select>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required></textarea>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="pendente">Pendente</option>
            <option value="resolvida">Resolvida</option>
            <option value="em andamento">Em Andamento</option>
        </select>

        <label for="condominio_id">Condomínio:</label>
        <select name="condominio_id" id="condominio_id" required>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
            @endforeach
        </select>

        <button type="submit">Criar</button>
    </form>
    <a href="{{ route('reclamacoes.index') }}">Voltar</a>
</body>

</html>