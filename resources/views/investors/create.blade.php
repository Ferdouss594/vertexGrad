@extends('layouts.app')

@section('title', 'Add New Investor')

@section('content')

<div class="page-header">
    <h4>Add New Investor</h4>
</div>

<div class="card">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops! There were some problems with your input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('investors.store') }}" method="POST">
            @csrf

            {{-- Username --}}
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                @error('username')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Name --}}
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="Student" {{ old('role')=='Student'?'selected':'' }}>Student</option>
                    <option value="Supervisor" {{ old('role')=='Supervisor'?'selected':'' }}>Supervisor</option>
                    <option value="Manager" {{ old('role')=='Manager'?'selected':'' }}>Manager</option>
                    <option value="Investor" {{ old('role')=='Investor'?'selected':'' }}>Investor</option>
                    <option value="Admin" {{ old('role')=='Admin'?'selected':'' }}>Admin</option>
                </select>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                    <option value="pending" {{ old('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="disabled" {{ old('status')=='disabled'?'selected':'' }}>Disabled</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Gender --}}
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                </select>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- City & State --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Company & Position --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                        @error('company')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}">
                        @error('position')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Investment Type & Source (منسدلة وجانب بعض) --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Investment Type</label>
                        <select name="investment_type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="Equity" {{ old('investment_type')=='Equity'?'selected':'' }}>Equity</option>
                            <option value="Debt" {{ old('investment_type')=='Debt'?'selected':'' }}>Debt</option>
                            <option value="Venture" {{ old('investment_type')=='Venture'?'selected':'' }}>Venture</option>
                        </select>
                        @error('investment_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Source</label>
                        <select name="source" class="form-control">
                            <option value="">Select Source</option>
                            <option value="Personal" {{ old('source')=='Personal'?'selected':'' }}>Personal</option>
                            <option value="Company" {{ old('source')=='Company'?'selected':'' }}>Company</option>
                            <option value="Fund" {{ old('source')=='Fund'?'selected':'' }}>Fund</option>
                        </select>
                        @error('source')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Budget --}}
            <div class="form-group">
                <label>Budget</label>
                <input type="number" step="0.01" name="budget" class="form-control" value="{{ old('budget') }}">
                @error('budget')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Investor</button>
        </form>
    </div>
</div>

@endsection
