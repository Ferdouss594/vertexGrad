<div class="filter-card mb-4">
    <div class="filter-card-header">
        <div>
            <h5>Filters</h5>
            <small class="text-muted">Search and navigate active, archived, or all investors.</small>
        </div>

        <div class="d-flex flex-wrap" style="gap: 10px;">
            <a href="{{ route('admin.investors.index', ['view' => 'active']) }}"
               class="btn-soft {{ $view === 'active' ? 'active-filter' : '' }}">
                <i class="fa fa-users mr-1"></i> Active Investors
            </a>

            <a href="{{ route('admin.investors.index', ['view' => 'archived']) }}"
               class="btn-soft {{ $view === 'archived' ? 'active-filter' : '' }}">
                <i class="fa fa-archive mr-1"></i> Archived Investors
            </a>

            <a href="{{ route('admin.investors.index', ['view' => 'all']) }}"
               class="btn-soft {{ $view === 'all' ? 'active-filter' : '' }}">
                <i class="fa fa-list mr-1"></i> All
            </a>
        </div>
    </div>

    <div class="p-4">
        <form method="GET" action="{{ route('admin.investors.index') }}">
            <input type="hidden" name="view" value="{{ request('view', 'active') }}">

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class="filter-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, email, or username" value="{{ request('search') }}">
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="filter-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="filter-label">City</label>
                    <input type="text" name="city" class="form-control" placeholder="City" value="{{ request('city') }}">
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="filter-label">Per Page</label>
                    <select name="per_page" class="form-select">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 mb-3 d-flex align-items-end">
                    <div class="w-100 d-flex" style="gap: 10px;">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 12px; font-weight: 700;">
                            <i class="fa fa-search mr-1"></i> Filter
                        </button>

                        <a href="{{ route('admin.investors.index', ['view' => request('view', 'active')]) }}"
                           class="btn btn-light w-100"
                           style="border-radius: 12px; font-weight: 700; border: 1px solid #dbe4f0;">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>