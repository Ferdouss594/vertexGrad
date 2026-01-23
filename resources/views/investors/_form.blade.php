<div class="row">
    <div class="col-md-6 mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $investor->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $investor->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $investor->phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Company</label>
        <input type="text" name="company" value="{{ old('company', $investor->company ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Position</label>
        <input type="text" name="position" value="{{ old('position', $investor->position ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Investment Type</label>
        <select name="investment_type" class="form-control">
            <option value="">-- Select --</option>
            <option value="Angel" {{ old('investment_type', $investor->investment_type ?? '') == 'Angel' ? 'selected' : '' }}>Angel</option>
            <option value="Venture Capital" {{ old('investment_type', $investor->investment_type ?? '') == 'Venture Capital' ? 'selected' : '' }}>Venture Capital</option>
            <option value="Private Equity" {{ old('investment_type', $investor->investment_type ?? '') == 'Private Equity' ? 'selected' : '' }}>Private Equity</option>
            <option value="Business Incubator" {{ old('investment_type', $investor->investment_type ?? '') == 'Business Incubator' ? 'selected' : '' }}>Business Incubator</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Budget</label>
        <input type="number" name="budget" value="{{ old('budget', $investor->budget ?? '') }}" class="form-control" step="0.01">
    </div>

    <div class="col-md-6 mb-3">
        <label>Source</label>
        <select name="source" class="form-control">
            <option value="">-- Select --</option>
            <option value="LinkedIn" {{ old('source', $investor->source ?? '') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
            <option value="Email" {{ old('source', $investor->source ?? '') == 'Email' ? 'selected' : '' }}>Email</option>
            <option value="Event" {{ old('source', $investor->source ?? '') == 'Event' ? 'selected' : '' }}>Event</option>
            <option value="Website" {{ old('source', $investor->source ?? '') == 'Website' ? 'selected' : '' }}>Website</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Active" {{ old('status', $investor->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ old('status', $investor->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-md-12 mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control" rows="4">{{ old('notes', $investor->notes ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('investors.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
