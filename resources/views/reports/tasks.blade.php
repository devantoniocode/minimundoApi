<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Relatório de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f6fc;
            color: #1b1f23;
        }

        h1 {
            text-align: center;
            color: #0366d6;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        thead {
            background-color: #0366d6;
            color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 0.5px solid #d1d5da;
        }

        tbody tr:nth-child(odd) {
            background-color: #eaf5ff;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        tbody tr:hover {
            background-color: #c8e1ff;
        }
    </style>
</head>

<body>
    <h1>Relatório de Tarefas</h1>
    <table>
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Tarefa</th>
                <th>Detalhes</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'Sistema' }}</td>
                <td>{{ $log->task->title ?? 'N/A' }}</td>
                <td>{{ $log->details }}</td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>