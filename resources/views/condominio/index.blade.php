<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Condomínios</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Lista de Condomínios</h1>
        <a href="{{ route('condominios.create') }}" class="btn btn-primary">Adicionar Condomínio</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($condominios as $condominio)
                    <tr>
                        <td>{{ $condominio->id }}</td>
                        <td>{{ $condominio->nome }}</td>
                        <td>
                            <a href="{{ route('condominios.edit', $condominio->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('condominios.destroy', $condominio->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
