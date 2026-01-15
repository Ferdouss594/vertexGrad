<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Investors Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>👥 Investors Report</h2>
    <p>Total Investors: {{ $investors->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investors as $investor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $investor->name }}</td>
                <td>{{ $investor->email }}</td>
                <td>{{ $investor->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
