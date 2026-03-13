<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🚀 Projects Report</title>
    <style>
        /* الخط العربي الافتراضي في DomPDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            color: #1b00ff;
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
        .status-active { background-color: #d1ecf1; color: #0c5460; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; font-weight: bold; }
        .status-completed { background-color: #d4edda; color: #155724; font-weight: bold; }

    </style>
</head>
<body>

    <h2>🚀 Projects Report</h2>
    <p class="total">Total Projects: {{ $projects->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Student</th>
                <th>Supervisor</th>
                <th>Manager</th>
                <th>Investor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->student->name ?? '—' }}</td>
                    <td>{{ $project->supervisor->name ?? '—' }}</td>
                    <td>{{ $project->manager->name ?? '—' }}</td>
                    <td>{{ $project->investor->name ?? '—' }}</td>
                    <td class="
                        @if(strtolower($project->status) == 'active') status-active
                        @elseif(strtolower($project->status) == 'pending') status-pending
                        @elseif(strtolower($project->status) == 'completed') status-completed
                        @else '' @endif">
                        {{ $project->status }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
