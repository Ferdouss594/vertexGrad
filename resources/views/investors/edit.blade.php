@extends('layouts.app')

@section('title', 'Edit Investor')

@section('content')
<h1>Edit Investor</h1>

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('investors.update', $investor->user) }}" method="POST">
    @csrf
    @method('PUT')

    

    <div class="row">
        {{-- User Info --}}
        <div class="col-md-6 mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $investor->user->name) }}" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $investor->user->email) }}" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Active" {{ old('status', $investor->user->status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status', $investor->user->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Investor Info --}}
        <div class="col-md-6 mb-3">
            <label>Company</label>
            <input type="text" name="company" value="{{ old('company', $investor->company) }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Position</label>
            <input type="text" name="position" value="{{ old('position', $investor->position) }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Investment Type</label>
            <input type="text" name="investment_type" value="{{ old('investment_type', $investor->investment_type) }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Budget</label>
            <input type="number" step="0.01" name="budget" value="{{ old('budget', $investor->budget) }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Source</label>
            <input type="text" name="source" value="{{ old('source', $investor->source) }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $investor->phone) }}" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes', $investor->notes) }}</textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Investor</button>
    <a href="{{ route('investors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
