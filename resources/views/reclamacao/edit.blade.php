<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reclamação</title>
</head>
<body>
    <h1>Editar Reclamação</h1>
    <form action="{{ route('reclamacoes.update', $reclamacao) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="{{ $reclamacao->tipo_reclamacao }}" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required>{{ $reclamacao->descricao }}</textarea>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="pendente" {{ $reclamacao->estado === 'pendente' ? 'selected' : '' }}>Pendente</option>
            <option value="resolvida" {{ $reclamacao->estado === 'resolvida' ? 'selected' : '' }}>Resolvida</option>
            <option value="em andamento" {{ $reclamacao->estado === 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
        </select>

        <label for="condominio_id">Condomínio:</label>
        <select name="condominio_id" id="condominio_id" required>
            @foreach ($condominios as $condominio)
                <option value="{{ $condominio->id }}" {{ $condominio->id === $reclamacao->condominio_id ? 'selected' : '' }}>{{ $condominio->nome }}</option>
            @endforeach
        </select>

        <button type="submit">Atualizar</button>
    </form>
    <a href="{{ route('reclamacoes.index') }}">Voltar</a>
</body>
</html>
