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
                    <a href="{{ route('admin.reports.investors.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('admin.reports.investors.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('investors')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

            <!-- Students Card -->
            <div class="report-card bg-green" id="students-card">
                <h2>🎓 Students</h2>
                <p class="count">Total: {{ $students->count() }}</p>
                <div class="btn-group mt-3">
                    <a href="{{ route('admin.reports.students.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('admin.reports.students.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('students')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

            <!-- Projects Card -->
            <div class="report-card bg-orange" id="projects-card">
                <h2>🚀 Projects</h2>
                <p class="count">Total: {{ $projects->count() }}</p>
                <div class="btn-group mt-3">
                    <a href="{{ route('admin.reports.projects.excel') }}" class="btn btn-light btn-sm">⬇ Excel</a>
                    <a href="{{ route('admin.reports.projects.pdf') }}" class="btn btn-light btn-sm">⬇ PDF</a>
                    <button onclick="printReport('projects')" class="btn btn-light btn-sm">🖨 Print</button>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
/* حاوية البطاقات */
.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    justify-content: center;
    margin-top: 20px;
}

/* البطاقة */
.report-card {
    position: relative;
    background: #faf5f4; /* خلفية فاتحة */
    border-radius: 16px;
    color: #333;
    text-align: center;
    flex: 1 1 280px;
    padding: 30px 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    overflow: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.bg-blue { background: linear-gradient(135deg, #e7e6fb, #f7f4f3); }
.bg-green { background: linear-gradient(135deg, #bcb9fc, #f9f0ee); }
.bg-orange { background: linear-gradient(135deg, #cdf4c2, #f6e9e6); }
.report-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

/* العنوان */
.report-card h2 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
}

/* الرقم */
.report-card .count {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
}

/* ألوان الحد السفلي للبطاقة لتمييز النوع */
.bg-blue { border-bottom: 6px solid #1e3a8a; }
.bg-green { border-bottom: 6px solid #10b981; }
.bg-orange { border-bottom: 6px solid #f97316; }

/* أزرار حديثة */
.btn-light {
    background-color: #f3f4f6;
    color: #111827;
    font-weight: 600;
    border-radius: 10px;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}

.btn-light:hover {
    background-color: #e5e7eb;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}

/* مجموعة الأزرار */
.btn-group {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

/* أيقونات صغيرة داخل الزر */
.btn-light i {
    font-size: 16px;
}

/* Responsive */
@media(max-width:768px){
    .cards-container { flex-direction: column; align-items: center; }
}
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
