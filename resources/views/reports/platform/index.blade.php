@extends('layouts.app')

@section('title','Platform Reports')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        <!-- العنوان الرئيسي -->
        <div class="text-center mb-5">
            <h1 style="font-weight:800; font-size:32px;">VERTEXGRAD REPORTS</h1>
           
        </div>

        <div class="cards-container">

            <!-- Investors Card -->
            <div class="report-card bg-blue" id="investors-card">
                <h2>👥 Investors</h2>
                <p class="count">Total: {{ $investors->count() }}</p>
                <div class="btn-group mt-3">
                    <a href="{{ route('reports.investors.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('reports.investors.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('investors')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

            <!-- Students Card -->
            <div class="report-card bg-green" id="students-card">
                <h2>🎓 Students</h2>
                <p class="count">Total: {{ $students->count() }}</p>
                <div class="btn-group mt-3">
                    <a href="{{ route('reports.students.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('reports.students.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('students')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

            <!-- Projects Card -->
            <div class="report-card bg-orange" id="projects-card">
                <h2>🚀 Projects</h2>
                <p class="count">Total: {{ $projects->count() }}</p>
                <div class="btn-group mt-3">
                    <a href="{{ route('reports.projects.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('reports.projects.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('projects')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CSS -->
<style>
.cards-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.report-card { padding:30px 20px; border-radius:15px; color:#fff; text-align:center; flex:1 1 250px; box-shadow:0 6px 20px rgba(0,0,0,0.12); transition:0.3s; }
.report-card:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.18); }
.report-card h2 { font-size:24px; margin-bottom:10px; }
.report-card .count { font-size:36px; font-weight:700; margin-bottom:10px; }
.bg-blue { background: #1a4183; }
.bg-green { background: #1a4183 }
.bg-orange { background: #1a4183 }
.btn-light { color:#333; background-color:#fff; border:none; font-weight:600; margin:0 3px; }
.btn-light:hover { background: #e8edf8; }
</style>

<!-- JS للطباعة داخل المتصفح -->
<script>
function printReport(type){
    let html = `<html><head><title>Report</title>
    <style>
        body { font-family: Arial, sans-serif; padding:20px; }
        h1 { text-align:center; margin-bottom:10px; color:#007bff; }
        p.total { font-weight:bold; margin-bottom:20px; font-size:16px; text-align:center; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #333; padding:8px; text-align:left; }
        th { background-color:#007bff; color:#fff; }
        tr:nth-child(even) { background-color:#f2f2f2; }
    </style>
    </head><body>`;

    if(type==='investors'){
        html += `<h1>📊 Investors Report</h1>`;
        html += `<p class="total">Total Investors: {{ $investors->count() }}</p>`;
        html += `<table><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Status</th></tr></thead><tbody>`;
        @foreach($investors as $investor)
        html += `<tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $investor->name }}</td>
            <td>{{ $investor->email }}</td>
            <td>{{ $investor->status }}</td>
        </tr>`;
        @endforeach
        html += `</tbody></table>`;
    }
    else if(type==='students'){
        html += `<h1>🎓 Students Report</h1>`;
        html += `<p class="total">Total Students: {{ $students->count() }}</p>`;
        html += `<table><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Major</th><th>Status</th></tr></thead><tbody>`;
        @foreach($students as $student)
        html += `<tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->student->major ?? '—' }}</td>
            <td>{{ $student->status }}</td>
        </tr>`;
        @endforeach
        html += `</tbody></table>`;
    }
    else if(type==='projects'){
        html += `<h1>🚀 Projects Report</h1>`;
        html += `<p class="total">Total Projects: {{ $projects->count() }}</p>`;
        html += `<table><thead><tr>
            <th>#</th><th>Project Name</th><th>Student</th><th>Supervisor</th>
            <th>Manager</th><th>Investor</th><th>Status</th>
        </tr></thead><tbody>`;
        @foreach($projects as $project)
        html += `<tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->student->name ?? '—' }}</td>
            <td>{{ $project->supervisor->name ?? '—' }}</td>
            <td>{{ $project->manager->name ?? '—' }}</td>
            <td>{{ $project->investor->name ?? '—' }}</td>
            <td>{{ $project->status }}</td>
        </tr>`;
        @endforeach
        html += `</tbody></table>`;
    }

    html += `</body></html>`;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(html);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>

@endsection
