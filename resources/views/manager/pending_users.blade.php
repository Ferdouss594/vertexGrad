@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<style>
   
    .stats-card {
        border-radius: 15px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-3px);
    }
    /* غطاء Modal أبيض شفاف */
.modal-backdrop {
    display: none !important;
}
.details-row td {
    padding: 5px;      /* مسافة حول الصندوق */
    height: auto;       /* يتيح للصف التوسع حسب المحتوى */
    background-color: transparent;
}
.user-details {
    padding: 5px;
    min-height: 100px;  /* ارتفاع أدنى يكبر الصندوق */
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    width: 50%;
    margin: 0 auto;
}
    /* ====== الأسهم ====== */
    .sort-arrows {
    display: inline-flex;
    flex-direction: row; /* بدل column */
    align-items: center;
    margin-left: 5px;
    gap: 2px; /* مسافة صغيرة بين السهمين */
}

.sort-arrows i {
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.sort-arrows i:hover {
    color: #0d6efd;
    transform: scale(1.2);
}


</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<div class="container-fluid">

    <!-- ======================= Stats + Add User ======================== -->
    <div class="row mb-4 g-3 justify-content-center">

        <!-- Pending -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="stats-card text-center" 
                 onclick="showTab('pendingTab')" 
                 style="cursor:pointer; height:120px; display:flex; flex-direction:column; justify-content:center;">
                <h6 class="text-muted mb-2">Pending</h6>
                <h3>{{ $pendingCount }}</h3>
            </div>
        </div>

        <!-- Active -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="stats-card text-center" 
                 onclick="showTab('activeTab')" 
                 style="cursor:pointer; height:120px; display:flex; flex-direction:column; justify-content:center;">
                <h6 class="text-muted mb-2">Active</h6>
                <h3>{{ $activeCount }}</h3>
            </div>
        </div>

        <!-- Inactive -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="stats-card text-center" 
                 onclick="showTab('inactiveTab')" 
                 style="cursor:pointer; height:120px; display:flex; flex-direction:column; justify-content:center;">
                <h6 class="text-muted mb-2">Inactive</h6>
                <h3>{{ $inactiveCount }}</h3>
            </div>
        </div>

        <!-- Disabled -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="stats-card text-center" 
                 onclick="showTab('disabledTab')" 
                 style="cursor:pointer; height:120px; display:flex; flex-direction:column; justify-content:center;">
                <h6 class="text-muted mb-2">Disabled</h6>
                <h3>{{ $disabledCount }}</h3>
            </div>
        </div>

        <!-- Add New User -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="stats-card text-center" 
                 style="background-color:#4e73df; color:white; cursor:pointer; height:120px; display:flex; flex-direction:column; justify-content:center;"
                 onclick="window.location.href='{{ route('manager.users.create') }}'">
                <h6 class="text-light mb-2">Add New User</h6>
                <h3><i class="bi bi-person-plus-fill"></i></h3>
            </div>
        </div>

    </div>

</div>

<!-- ======================= JS للتبديل بين التبويبات ======================== -->
<script>
function showTab(tabId) {
    let tabTriggerEl = document.querySelector(`a[href="#${tabId}"]`);
    let tab = new bootstrap.Tab(tabTriggerEl);
    tab.show();
}
</script>


<!-- ======================= Tabs ======================== -->
<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#pendingTab">Pending</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#activeTab">Active</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#inactiveTab">Inactive</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#disabledTab">Disabled</a></li>
</ul>

<!-- ======================= Tabs Content ======================== -->
<div class="tab-content">

    <!-- TAB TEMPLATE -->
    @php
        $tabs = [
            'pendingTab' => $pendingUsers,
            'activeTab' => $activeUsers,
            'inactiveTab' => $inactiveUsers,
            'disabledTab' => $disabledUsers,
        ];
    @endphp

  @foreach ($tabs as $tabId => $users)
<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}">

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
           <tr>
    <th># 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th>Name 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th>Email 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th>Status 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th>Role 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th>Last Login 
        <span class="sort-arrows">
            <i class="icon-copy ion-arrow-up-c" onclick="sortTable(this,'asc')"></i>
            <i class="icon-copy ion-arrow-down-c" onclick="sortTable(this,'desc')"></i>
        </span>
    </th>
    <th class="text-center">Actions</th>
</tr>

        </thead>

        <tbody>

        @forelse ($users as $user)
        <!-- صف المستخدم -->
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
                <span class="badge 
                    @if($user->status=='active') bg-success 
                    @elseif($user->status=='inactive') bg-warning
                    @elseif($user->status=='disabled') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($user->status) }}
                </span>
            </td>

            <td>{{ $user->role }}</td>
            <td>{{ $user->last_login ?? '—' }}</td>

            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    <!-- زر تعديل -->
                    <a href="{{ route('manager.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <!-- زر حذف -->
                    <form action="{{ route('manager.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    <!-- زر تسجيل خروج -->
                    <form action="{{ route('manager.users.force-logout', $user->id) }}" method="POST" 
      onsubmit="return confirm('هل أنت متأكد من تسجيل خروج هذا المستخدم؟');" style="display:inline-block;">
    @csrf
    <button type="submit" class="btn btn-sm btn-warning">
        <i class="bi bi-box-arrow-right"></i>
    </button>
</form>


                    <!-- زر عرض التفاصيل -->
                    <button class="btn btn-sm btn-info btn-show-details" data-user-id="{{ $user->id }}">
    <i class="bi bi-info-circle"></i>
</button>

                </div>
            </td>
        </tr>

        <!-- صف التفاصيل القابل للطي -->
        <tr class="details-row" style="display:none;" data-user-id="{{ $user->id }}">
            <td colspan="7">
                <div class="user-details">
                    <strong>Last Activity:</strong> {{ $user->last_activity ?? '—' }} <br>
                    <strong>IP Address:</strong> {{ $user->ip_address ?? '—' }} <br>
                    <strong>Device:</strong> {{ $user->device ?? '—' }} <br>
                    <strong>Browser:</strong> {{ $user->browser ?? '—' }} <br>
                </div>
            </td>
        </tr>

        @empty
        <tr><td colspan="7" class="text-center text-muted">No Users Found</td></tr>
        @endforelse

        </tbody>
    </table>

</div>
@endforeach


<!-- JS لتفعيل عرض التفاصيل -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-show-details').forEach(button => {
        button.addEventListener('click', function() {

            const userId = this.dataset.userId;

            fetch(`/manager/users/${userId}`)

                .then(response => response.json())
                .then(data => {

                    let details = `
                        <strong>Username:</strong> ${data.username}<br>
                        <strong>Name:</strong> ${data.name}<br>
                        <strong>Email:</strong> ${data.email}<br>
                        <strong>Role:</strong> ${data.role}<br>
                        <strong>Status:</strong> ${data.status}<br>
                        <strong>Gender:</strong> ${data.gender}<br>
                        <strong>City:</strong> ${data.city}<br>
                        <strong>State:</strong> ${data.state}<br>
                        <strong>Last Login:</strong> ${data.last_login ?? '—'}<br>
                        <strong>Last Activity:</strong> ${data.last_activity ?? '—'}<br>
                        <strong>IP:</strong> ${data.login_ip ?? '—'}<br>
                        <strong>Device:</strong> ${data.device ?? '—'}<br>
                        <strong>Browser:</strong> ${data.browser ?? '—'}<br>
                        <strong>OS:</strong> ${data.os ?? '—'}
                    `;

                    document.querySelector('#userDetailsModal .modal-body').innerHTML = details;

                    new bootstrap.Modal(document.getElementById('userDetailsModal')).show();
                })
                .catch(() => alert('فشل جلب بيانات المستخدم'));
        });
    });

});
</script>

<!-- JS لترتيب الجدول عند الضغط على الأسهم -->
<script>
function sortTable(el, order) {
    const th = el.closest('th');
    const table = th.closest('table');
    const tbody = table.querySelector('tbody');
    const index = Array.from(th.parentNode.children).indexOf(th);

    const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.classList.contains('details-row'));

    rows.sort((a, b) => {
        let aText = a.children[index].innerText.trim().toLowerCase();
        let bText = b.children[index].innerText.trim().toLowerCase();

        if(!isNaN(aText) && !isNaN(bText)){
            return order === 'asc' ? aText - bText : bText - aText;
        }

        return order === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });

    rows.forEach(row => tbody.appendChild(row));

    // ترتيب صفوف التفاصيل
    rows.forEach(row => {
        const detailRow = tbody.querySelector(`.details-row[data-user-id="${row.querySelector('.btn-show-details').dataset.userId}"]`);
        if(detailRow) tbody.appendChild(detailRow);
    });
}
</script>


<!-- Modal عرض التفاصيل -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- البيانات ستظهر هنا عبر JS -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endsection
