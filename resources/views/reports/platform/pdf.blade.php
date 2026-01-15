<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Platform Report</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        h2, h3 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

<h2>Platform Report</h2>

{{-- Investors --}}
<h3>Investors ({{ count($investors) }})</h3>
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
        @foreach($investors as $i => $inv)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $inv->name }}</td>
            <td>{{ $inv->email }}</td>
            <td>{{ ucfirst($inv->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="page-break"></div>

{{-- Students --}}
<h3>Students ({{ count($students) }})</h3>
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
        @foreach($students as $i => $stu)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $stu->name }}</td>
            <td>{{ $stu->email }}</td>
            <td>{{ $stu->student->major ?? '-' }}</td>
            <td>{{ ucfirst($stu->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="page-break"></div>

{{-- Projects --}}
<h3>Projects ({{ count($projects) }})</h3>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Project Name</th>
            <th>Student</th>
            <th>Status</th>
            <th>Budget</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $i => $pro)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $pro->name }}</td>
            <td>{{ $pro->student->name ?? '-' }}</td>
            <td>{{ $pro->status }}</td>
            <td>{{ $pro->budget ?? '0' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
