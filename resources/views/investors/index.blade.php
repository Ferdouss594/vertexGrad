@extends('layouts.app')
@section('title','Investors')

@section('content')

{{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- ===================== Stats Cards ===================== -->
<div class="row g-3 mb-4">
    {{-- Total Investors --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-users fa-2x text-primary mb-2"></i>
                <div class="text-uppercase small text-muted">Total Investors</div>
                <h4 class="fw-bold">{{ $stats['total'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Active Investors --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-user-check fa-2x text-success mb-2"></i>
                <div class="text-uppercase small text-muted">Active</div>
                <h4 class="fw-bold">{{ $stats['active'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Inactive Investors --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-user-times fa-2x text-danger mb-2"></i>
                <div class="text-uppercase small text-muted">Inactive</div>
                <h4 class="fw-bold">{{ $stats['inactive'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Total Budget --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-dollar-sign fa-2x text-warning mb-2"></i>
                <div class="text-uppercase small text-muted">Total Budget</div>
                <h4 class="fw-bold">${{ number_format($stats['budget'] ?? 0,2) }}</h4>
            </div>
        </div>
    </div>

    {{-- Top Company --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-building fa-2x text-secondary mb-2"></i>
                <div class="text-uppercase small text-muted">Top Company</div>
                <h6 class="fw-bold mb-0">{{ $stats['top_company']->company ?? 'N/A' }}</h6>
            </div>
        </div>
    </div>
</div>

<!-- ===================== Table Card ===================== -->
<div class="card shadow-sm">
    {{-- Header --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0 fw-bold"><i class="fa fa-list me-2"></i> Investors List</h5>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.investors.index') }}" 
               class="btn btn-outline-primary btn-sm" 
               style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa fa-users me-1"></i> Active
            </a>

            <a href="{{ route('admin.investors.create') }}" 
               class="btn btn-primary btn-sm" 
               style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                <i class="fa fa-plus me-1"></i> Add Investor
            </a>

            <a href="{{ route('admin.investors.export','xlsx') }}" 
               class="btn btn-outline-secondary btn-sm" 
               style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa fa-file-export me-1"></i> Export
            </a>

            <button class="btn btn-outline-success btn-sm" 
                    style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa fa-file-import me-1"></i> Import
            </button>
       

    {{-- Body --}}
    <div class="card-body p-0">
        <!-- Table will go here -->
    </div>
</div>




    <div class="card-body">

        <!-- ===================== Filters ===================== -->
        <form method="GET" action="{{ route('admin.investors.index') }}">
            <div class="row mb-3 align-items-end g-3">

                <!-- Show entries -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Show entries</label>
                    <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                        <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                        <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                        <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>

            </div>
        </form>




    <table class="data-table table stripe hover nowrap">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Company</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Position</th>
                <th>Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
@foreach($investors as $inv)
<tr id="investor-{{ $inv->id }}">
    {{-- الرقم التسلسلي --}}
    <td>{{ $loop->iteration + ($investors->currentPage() - 1) * $investors->perPage() }}</td>


    {{-- الاسم --}}
    <td>{{ $inv->user?->name ?? $inv->name ?? '—' }}</td>

    {{-- الشركة --}}
    <td>{{ $inv->investor?->company ?? '—' }}</td>
<td>{{ $inv->investor?->phone ?? '—' }}</td>

    

    {{-- البريد الإلكتروني --}}
    <td>{{ $inv->user?->email ?? $inv->email ?? '—' }}</td>

    {{-- الوظيفة --}}
    <td>{{ $inv->investor?->position ?? '—' }}</td>

    {{-- تاريخ الإنشاء --}}
    <td>{{ optional($inv->created_at)->format('Y-m-d') ?? '—' }}</td>

    {{-- أزرار العمليات --}}
    <td class="text-center">
        <a href="{{ route('admin.investors.show', $inv->id) }}" class="btn btn-sm btn-info" title="Show">
            <i class="fa fa-id-card"></i>
        </a>
        <a href="{{ route('admin.investors.edit', $inv->id) }}" class="btn btn-sm btn-warning" title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    </td>
</tr>
@endforeach
</tbody>

    

        </tbody>
    </table>
    {{ $investors->links() }}
</div>

@endsection

@push('styles')
<style>
.data-table thead th {
    background-color: #094358 !important;
    color: #ffffff !important;
    font-weight: bold !important;
    text-align: center !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.data-table thead th').forEach(function(th){
        th.style.backgroundColor = '#094358';
        th.style.color = '#ffffff';
        th.style.fontWeight = 'bold';
        th.style.textAlign = 'center';
    });
});
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('.data-table').DataTable({
        "initComplete": function(settings, json) {
            $('.data-table thead th').css({
                'background-color': '#094358',
                'color': '#ffffff',
                'font-weight': 'bold',
                'text-align': 'center'
            });
        }
    });
});
</script>
@endpush

@push('scripts')
<script>
// Import File
document.getElementById('importBtn').addEventListener('click', function(){ 
    document.getElementById('importFile').click(); 
});
document.getElementById('importFile').addEventListener('change', function(){
    var f = this.files[0];
    if(!f) return;
    var fd = new FormData();
    fd.append('file', f);
    fd.append('_token','{{ csrf_token() }}');
    fetch("{{ route('admin.investors.import') }}", { method:'POST', body: fd })
    .then(r=>r.text())
    .then(()=> location.reload());
});

// Soft Delete / Archive
document.querySelectorAll('.delete-investor').forEach(btn=>{
    btn.addEventListener('click', function(){
        if(!confirm('Are you sure you want to archive this investor?')) return;
        let id = this.dataset.id;
        fetch(`/investors/${id}`, {
            method:'DELETE',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
        })
        .then(r=>r.json())
        .then(data=>{ if(data.success) document.getElementById(`investor-${id}`).remove(); });
    });
});

// Restore
document.querySelectorAll('.restore-investor').forEach(btn=>{
    btn.addEventListener('click', function(){
        let id = this.dataset.id;
        fetch(`/investors/${id}/restore`, {
            method:'POST',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
        })
        .then(r=>r.json())
        .then(data=>{ if(data.success) document.getElementById(`investor-${id}`).remove(); });
    });
});

// Force Delete
document.querySelectorAll('.force-delete-investor').forEach(btn=>{
    btn.addEventListener('click', function(){
        if(!confirm('This will delete permanently!')) return;
        let id = this.dataset.id;
        fetch(`/investors/${id}/force-delete`, {
            method:'DELETE',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
        })
        .then(r=>r.json())
        .then(data=>{ if(data.success) document.getElementById(`investor-${id}`).remove(); });
    });
});
</script>
<script>
$('#editInvestorForm').on('submit', function(e){
    e.preventDefault(); 
    let id = $('#investor_id').val();
    $.ajax({
        url: '/investors/' + id,
        method: 'PUT',
        data: $(this).serialize(),
        success: function(response){
            // تحديث الصف مباشرة
            let row = $('#investor-' + id);
            row.find('td:nth-child(2)').text(response.user.name);
            row.find('td:nth-child(3)').text(response.company ?? '—');
            row.find('td:nth-child(4)').text(response.phone ?? '—');
            row.find('td:nth-child(5)').text(response.user.email ?? '—');
            row.find('td:nth-child(6)').text(response.position ?? '—');
            alert('تم تحديث المستثمر بنجاح!');
        },
        error: function(err){
            alert('حدث خطأ أثناء التحديث');
        }
    });
});
</script>

@endpush
