<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Reclamação</title>
</head>
<body>
    <h1>Criar Reclamação</h1>
    <form action="{{ route('reclamacao.store') }}" method="POST">
        @csrf
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>

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
    <a href="{{ route('reclamacao.index') }}">Voltar</a>
</body>
</html>