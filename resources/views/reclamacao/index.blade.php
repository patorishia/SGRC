<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Reclamações</title>
</head>
<body>
    <h1>Reclamações</h1>
    <a href="{{ route('reclamacao.create') }}">Adicionar Reclamação</a>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reclamacoes as $reclamacao)
                <tr>
                    <td>{{ $reclamacao->titulo }}</td>
                    <td>{{ $reclamacao->descricao }}</td>
                    <td>{{ $reclamacao->estado }}</td>
                    <td>
                        <a href="{{ route('reclamacao.edit', $reclamacao) }}">Editar</a>
                        <form action="{{ route('reclamacao.destroy', $reclamacao) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
