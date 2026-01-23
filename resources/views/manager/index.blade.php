@extends('layouts.app')
@section('title','Managers')

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
    {{-- Total Managers --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-users fa-2x text-primary mb-2"></i>
                <div class="text-uppercase small text-muted">Total Managers</div>
                <h4 class="fw-bold">{{ $stats['total'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Active Managers --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-user-check fa-2x text-success mb-2"></i>
                <div class="text-uppercase small text-muted">Active</div>
                <h4 class="fw-bold">{{ $stats['active'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Inactive Managers --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-user-times fa-2x text-danger mb-2"></i>
                <div class="text-uppercase small text-muted">Inactive</div>
                <h4 class="fw-bold">{{ $stats['inactive'] }}</h4>
            </div>
        </div>
    </div>

    {{-- Departments --}}
    <div class="col-md-2 col-6">
        <div class="card border-0 shadow-sm text-center h-100 bg-gradient-light">
            <div class="card-body">
                <i class="fa fa-building fa-2x text-warning mb-2"></i>
                <div class="text-uppercase small text-muted">Departments</div>
                <h4 class="fw-bold">{{ $stats['departments'] ?? 0 }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- ===================== Table Card ===================== -->
<div class="card shadow-sm">
    {{-- Header --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0 fw-bold"><i class="fa fa-list me-2"></i> Managers List</h5>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('manager.index') }}" 
               class="btn btn-outline-primary btn-sm" 
               style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa fa-users me-1"></i> All
            </a>

            <a href="{{ route('manager.create') }}" 
               class="btn btn-primary btn-sm" 
               style="border-radius: 6px; font-weight: 500; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                <i class="fa fa-plus me-1"></i> Add Manager
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="card-body">

        <!-- ===================== Filters ===================== -->
        <form method="GET" action="{{ route('manager.index') }}">
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
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($managers as $manager)
                <tr id="manager-{{ $manager->id }}">
                    <td>{{ $loop->iteration + ($managers->currentPage() - 1) * $managers->perPage() }}</td>
                    <td>{{ $manager->user->name ?? '—' }}</td>
                    <td>{{ $manager->user->email ?? '—' }}</td>
                    <td>{{ $manager->department ?? '—' }}</td>
                    <td>{{ $manager->last_login ?? '—' }}</td>
                    <td class="text-center">
                        <a href="{{ route('manager.edit', $manager->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('manager.destroy', $manager->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $managers->links() }}

    </div>
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
