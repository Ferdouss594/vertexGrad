<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon primary">
                <i class="fa fa-users"></i>
            </div>
            <div class="stats-number">{{ $stats['total'] ?? 0 }}</div>
            <p class="stats-label">Total Investors</p>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon success">
                <i class="fa fa-user-check"></i>
            </div>
            <div class="stats-number">{{ $stats['active'] ?? 0 }}</div>
            <p class="stats-label">Active</p>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon danger">
                <i class="fa fa-user-times"></i>
            </div>
            <div class="stats-number">{{ $stats['inactive'] ?? 0 }}</div>
            <p class="stats-label">Inactive</p>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon info">
                <i class="fa fa-archive"></i>
            </div>
            <div class="stats-number">{{ $stats['archived'] ?? 0 }}</div>
            <p class="stats-label">Archived</p>
        </div>
    </div>

    <div class="col-xl-2 col-md-6 col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon warning">
                <i class="fa fa-dollar-sign"></i>
            </div>
            <div class="stats-number">${{ number_format($stats['budget'] ?? 0, 2) }}</div>
            <p class="stats-label">Total Budget</p>
        </div>
    </div>

    <div class="col-xl-2 col-md-6 col-12 mb-3">
        <div class="stats-card">
            <div class="stats-icon primary">
                <i class="fa fa-building"></i>
            </div>
            <div class="stats-number" style="font-size: 16px;">
                {{ $stats['top_company']->company ?? 'N/A' }}
            </div>
            <p class="stats-label">Top Company</p>
        </div>
    </div>
</div>