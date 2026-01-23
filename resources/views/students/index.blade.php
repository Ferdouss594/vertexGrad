


@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Student
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Row -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-2">
            <label class="form-label small text-muted">Show entries</label>
            <select id="entries" class="form-select form-select-sm" onchange="changeEntries(this)">
                <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>
                <option value="50" {{ request('per_page')==50?'selected':'' }}>50</option>
                <option value="100" {{ request('per_page')==100?'selected':'' }}>100</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small text-muted">Status</label>
            <select id="statusFilter" class="form-select form-select-sm" onchange="filterStatus(this)">
                <option value="">All</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>
    </div>

    <!-- Students Table -->
    <div class="table-responsive shadow-sm rounded">
        <table id="studentsTable" class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="sortable text-center" data-column="name">Name <i class="bi"></i></th>
                    <th class="sortable text-center" data-column="email">Email <i class="bi"></i></th>
                    <th class="sortable text-center" data-column="major">Major <i class="bi"></i></th>
                    <th class="sortable text-center" data-column="phone">Phone <i class="bi"></i></th>
                    <th class="sortable text-center" data-column="address">Address <i class="bi"></i></th>
                    <th class="sortable text-center" data-column="status">Status <i class="bi"></i></th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $user)
                <tr>
                    <td>{{ $user->name ?? '—' }}</td>
                    <td>{{ $user->email ?? '—' }}</td>
                    <td>{{ $user->student?->major ?? '—' }}</td>
                    <td>{{ $user->student?->phone ?? '—' }}</td>
                    <td>{{ $user->student?->address ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge 
                            @if($user->status=='active') bg-success
                            @elseif($user->status=='inactive') bg-warning
                            @elseif($user->status=='pending') bg-secondary
                            @else bg-light text-dark @endif">
                            {{ ucfirst($user->status ?? '—') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 flex-wrap justify-content-center">
                            <a href="{{ route('students.show', $user->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('students.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('students.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No students found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $students->appends(request()->query())->links() }}
    </div>

</div>

<style>
.sortable { cursor:pointer; user-select:none; }
.sortable i { margin-left:5px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    
function changeEntries(select){
    const perPage = select.value;
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    window.location.href = url;
}

function filterStatus(select){
    const status = select.value;
    const url = new URL(window.location.href);
    if(status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    window.location.href = url;
}

// ================= Sortable Columns with small arrows like Investors =================
document.addEventListener('DOMContentLoaded', function(){
    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

    const comparer = (idx, asc) => (a,b) => {
        const v1 = getCellValue(asc ? a : b, idx);
        const v2 = getCellValue(asc ? b : a, idx);
        if(!isNaN(v1) && !isNaN(v2)) return v1 - v2;
        return v1.toString().localeCompare(v2);
    };

    document.querySelectorAll('.sortable').forEach(th=>{
        th.addEventListener('click', function(){
            const table = th.closest('table');
            const tbody = table.querySelector('tbody');
            Array.from(tbody.querySelectorAll('tr'))
                 .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                 .forEach(tr => tbody.appendChild(tr));

            // Update arrows like Investors table
            table.querySelectorAll('.sortable i').forEach(i=>i.className='');
            this.querySelector('i').className = this.asc ? 'bi bi-caret-up-fill' : 'bi bi-caret-down-fill';
        });
    });
});
</script>
@endsection
