<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎓 Students Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            color: #00aaff;
            text-align: center;
            margin-bottom: 10px;
        }

        p.total {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* ألوان الحالة */
        .status-active { background-color: #d4edda; color: #155724; font-weight: bold; }
        .status-inactive { background-color: #f8d7da; color: #721c24; font-weight: bold; }

    </style>
</head>
<body>

    <h2>🎓 Students Report</h2>
    <p class="total">Total Students: {{ $students->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->student->major ?? '—' }}</td>
                    <td class="
                        @if(strtolower($student->status) == 'active') status-active
                        @elseif(strtolower($student->status) == 'inactive') status-inactive
                        @else '' @endif">
                        {{ $student->status }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
