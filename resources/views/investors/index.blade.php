@extends('layouts.app')
@section('title','Investors')
@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="pd-20 bg-white border-radius-4 shadow-sm text-center" style="height:100px;">
            <h6>Total Investors</h6>
            <h4>{{ $stats['total'] }}</h4>
        </div>
    </div>
    <div class="col-md-2">
        <div class="pd-20 bg-white border-radius-4 shadow-sm text-center" style="height:100px;">
            <h6>Active Investors</h6>
            <h4>{{ $stats['active'] }}</h4>
        </div>
    </div>
    <div class="col-md-2">
        <div class="pd-20 bg-white border-radius-4 shadow-sm text-center" style="height:100px;">
            <h6>Inactive Investors</h6>
            <h4>{{ $stats['inactive'] }}</h4>
        </div>
    </div>
    <div class="col-md-2">
        <div class="pd-20 bg-white border-radius-4 shadow-sm text-center" style="height:100px;">
            <h6>Total Budget</h6>
            <h4>${{ number_format($stats['budget'] ?? 0,2) }}</h4>

        </div>
    </div>
    <div class="col-md-2">
        <div class="pd-20 bg-white border-radius-4 shadow-sm text-center" style="height:100px;">
            <h6>Top Company</h6>
            <h4>{{ $stats['top_company']->company ?? 'N/A' }}</h4>
        </div>
    </div>
</div>

<!-- Main Table -->
<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h5>Investors List</h5>
        <div class="d-flex align-items-center gap-2">
            <!-- Active / Archived Buttons -->
            <a href="{{ route('investors.index') }}" class="btn btn-outline-primary">
                <i class="fa fa-users"></i> Active
            </a>
            

            <!-- Add / Export / Import -->
            <a href="{{ route('investors.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Investor
            </a>
            <a href="{{ route('investors.export','xlsx') }}" class="btn btn-outline-secondary">
                <i class="fa fa-file-export"></i> Export
            </a>
            <button id="importBtn" class="btn btn-outline-secondary">
                <i class="fa fa-file-import"></i> Import
            </button>
            <input type="file" id="importFile" style="display:none;">
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-3">
        <form method="get" class="form-inline d-flex gap-2">
            <select name="company" class="form-control">
    <option value="">Filter by Company</option>
    @if(!empty($stats['by_company']))
        @foreach($stats['by_company'] as $c)
            <option value="{{ $c->company }}" @if(request('company')==$c->company) selected @endif>{{ $c->company }}</option>
        @endforeach
    @endif
</select>


            <select name="position" class="form-control">
                <option value="">Filter by Position</option>
                @foreach($investors->pluck('position')->unique() as $pos)
                    <option value="{{ $pos }}" @if(request('position')==$pos) selected @endif>{{ $pos }}</option>
                @endforeach
            </select>

            <button class="btn btn-sm btn-primary">
                <i class="fa fa-filter"></i> Filter
            </button>
        </form>
    </div>

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
                <td>{{ $loop->iteration + ($investors->currentPage()-1)*$investors->perPage() }}</td>
                <td>{{ $inv->user->name ?? $inv->name }}</td>
                <td>{{ $inv->company }}</td>
                <td>{{ $inv->phone }}</td>
                <td>{{ $inv->user->email ?? $inv->email }}</td>
                <td>{{ $inv->position }}</td>
                <td>{{ $inv->created_at->format('Y-m-d') }}</td>
                <td class="text-center">
                    <a href="{{ route('investors.show',$inv) }}" class="btn btn-sm btn-info" title="Show">
                        <i class="fa fa-id-card"></i>
                    </a>
                    <a href="{{ route('investors.edit',$inv) }}" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>

                    
                </td>
            </tr>
            @endforeach
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
    fetch("{{ route('investors.import') }}", { method:'POST', body: fd })
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
@endpush
