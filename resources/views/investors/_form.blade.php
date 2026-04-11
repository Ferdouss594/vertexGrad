@php
    $isEdit = isset($investor) && $investor;
@endphp

<style>
    .investor-form-page .main-panel {
        background: #fff;
        border: 1px solid #e8ecf4;
        border-radius: 24px;
        box-shadow: 0 8px 20px rgba(18, 38, 63, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .investor-form-page .panel-head {
        padding: 22px 24px 10px;
        border-bottom: 1px solid rgba(232, 236, 244, 0.7);
    }

    .investor-form-page .panel-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: #172033;
    }

    .investor-form-page .panel-subtitle {
        margin-top: 6px;
        color: #7b8497;
        font-size: 0.9rem;
    }

    .investor-form-page .table-wrap {
        padding: 20px 24px 26px;
    }

    .investor-form-page label {
        font-size: 0.82rem;
        color: #7b8497;
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
    }

    .investor-form-page .form-control,
    .investor-form-page .form-select {
        min-height: 46px;
        border-radius: 14px;
        border: 1px solid #dfe5ef;
        box-shadow: none;
        padding: 12px 14px;
    }

    .investor-form-page .form-control:focus,
    .investor-form-page .form-select:focus {
        border-color: rgba(78, 115, 223, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.12);
    }

    .investor-form-page textarea.form-control {
        min-height: 120px;
    }

    .investor-form-page .search-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .investor-form-page .reset-btn {
        min-height: 46px;
        border-radius: 14px;
        font-weight: 700;
        padding: 10px 18px;
        background: #eef2f8;
        color: #344054;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .investor-form-page .reset-btn:hover {
        color: #344054;
        text-decoration: none;
    }
</style>

<div class="investor-form-page">
    <div class="main-panel">
        <div class="panel-head">
            <h2 class="panel-title">
                <i class="fa fa-user mr-2"></i>Account Information
            </h2>
            <div class="panel-subtitle">Basic account details and access information for the investor.</div>
        </div>

        <div class="table-wrap">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"
                           value="{{ old('username', $investor->user->username ?? '') }}">
                    @error('username')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $investor->user->name ?? '') }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $investor->user->email ?? '') }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                @unless($isEdit)
                    <div class="col-md-6 mb-3">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                @endunless

                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="Active" {{ old('status', $investor->user->status ?? 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $investor->user->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $investor->user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $investor->user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control"
                           value="{{ old('city', $investor->user->city ?? '') }}">
                    @error('city')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control"
                           value="{{ old('state', $investor->user->state ?? '') }}">
                    @error('state')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="main-panel">
        <div class="panel-head">
            <h2 class="panel-title">
                <i class="fa fa-briefcase mr-2"></i>Investor Profile
            </h2>
            <div class="panel-subtitle">Professional and investment-related information for this investor profile.</div>
        </div>

        <div class="table-wrap">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $investor->phone ?? '') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Company</label>
                    <input type="text" name="company" class="form-control"
                           value="{{ old('company', $investor->company ?? '') }}">
                    @error('company')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Position</label>
                    <input type="text" name="position" class="form-control"
                           value="{{ old('position', $investor->position ?? '') }}">
                    @error('position')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Investment Type</label>
                    <select name="investment_type" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="Angel" {{ old('investment_type', $investor->investment_type ?? '') == 'Angel' ? 'selected' : '' }}>Angel</option>
                        <option value="Venture Capital" {{ old('investment_type', $investor->investment_type ?? '') == 'Venture Capital' ? 'selected' : '' }}>Venture Capital</option>
                        <option value="Private Equity" {{ old('investment_type', $investor->investment_type ?? '') == 'Private Equity' ? 'selected' : '' }}>Private Equity</option>
                        <option value="Business Incubator" {{ old('investment_type', $investor->investment_type ?? '') == 'Business Incubator' ? 'selected' : '' }}>Business Incubator</option>
                    </select>
                    @error('investment_type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Budget</label>
                    <input type="number" name="budget" class="form-control" step="0.01"
                           value="{{ old('budget', $investor->budget ?? '') }}">
                    @error('budget')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Source</label>
                    <select name="source" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="LinkedIn" {{ old('source', $investor->source ?? '') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="Email" {{ old('source', $investor->source ?? '') == 'Email' ? 'selected' : '' }}>Email</option>
                        <option value="Event" {{ old('source', $investor->source ?? '') == 'Event' ? 'selected' : '' }}>Event</option>
                        <option value="Website" {{ old('source', $investor->source ?? '') == 'Website' ? 'selected' : '' }}>Website</option>
                    </select>
                    @error('source')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $investor->investorNotes ?? '') }}</textarea>
                    @error('notes')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap" style="gap: 12px;">
        <button class="btn btn-primary search-btn" type="submit">
            <i class="fa fa-save mr-1"></i>
            {{ $isEdit ? 'Update Investor' : 'Create Investor' }}
        </button>

        <a href="{{ route('admin.investors.index') }}" class="reset-btn">
            Cancel
        </a>
    </div>
</div>