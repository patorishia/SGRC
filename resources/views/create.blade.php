<!-- resources/views/create.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Condomínio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Criar Condomínio</h1>
        <form action="{{ route('condominios.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome do Condomínio</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Criar</button>
            <a href="{{ route('condominios.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>
