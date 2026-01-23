<ul class="list-unstyled mb-0">
    @forelse($permissions as $perm)
        <li>
            {{ $perm->permission_name }}
            @if($perm->status == 'inactive')
                <span class="badge bg-secondary">Inactive</span>
            @endif
        </li>
    @empty
        <li>—</li>
    @endforelse
</ul>
