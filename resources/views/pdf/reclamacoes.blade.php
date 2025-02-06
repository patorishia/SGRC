<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Relatório de Reclamações') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 class="header">{{ __('Relatório de Reclamações') }}</h1>
    <table>
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Condomínio') }}</th>
                <th>{{ __('Condómino') }}</th>
                <th>{{ __('Tipo de Reclamação') }}</th>
                <th>{{ __('Estado') }}</th>
                <th>{{ __('Descrição') }}</th>
                <th>{{ __('Criado a') }}</th>
                <th>{{ __('Atualizado a') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reclamacoes as $reclamacao)
            <tr>
                <td>{{ $reclamacao->id }}</td>
                <td>{{ $reclamacao->condominio->nome }}</td>
                <td>{{ $reclamacao->user->name }}</td>
                <td>{{ $reclamacao->tipoReclamacao->tipo }}</td>
                <td>{{ $reclamacao->estado->nome }}</td>
                <td>{{ $reclamacao->descricao }}</td>
                <td>{{ $reclamacao->created_at }}</td>
                <td>{{ $reclamacao->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
