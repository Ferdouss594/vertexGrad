@extends('layouts.app')

@section('title', 'Edit Contract')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="card-box p-4">
        <h4 class="mb-4">Edit Contract for {{ $investor->user?->name }}</h4>

        <form action="{{ route('admin.investors.contracts.update', [$investor->id, $contract->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $contract->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $contract->type) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" {{ old('status', $contract->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $contract->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ old('status', $contract->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ old('status', $contract->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($contract->start_date)->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($contract->end_date)->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Replace Contract File</label>
                <input type="file" name="file" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="5">{{ old('notes', $contract->notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Contract</button>
        </form>
    </div>
</div>
@endsection