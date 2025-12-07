@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Edit User: {{ $user->name }}</h3>

    <!-- رسائل النجاح أو الخطأ -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('manager.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- صورة المستخدم -->
        <div class="text-center mb-3">
            <div style="position: relative; display: inline-block; width: 120px; height: 120px;">
                <img id="profilePreview" src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('src/images/avatar.png') }}" 
                     alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                
                <label for="profileImage" 
                       style="position: absolute; bottom: 0; right: 0; width: 35px; height: 35px; 
                              background-color: #5bc0de; color: white; border-radius: 50%; 
                              display: flex; justify-content: center; align-items: center; cursor: pointer; font-weight: bold;">+</label>
                <input type="file" name="profile_image" id="profileImage" class="d-none" accept="image/*">
            </div>
        </div>

        <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Role -->
            <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="Student" {{ old('role', $user->role)=='Student' ? 'selected' : '' }}>Student</option>
                    <option value="Supervisor" {{ old('role', $user->role)=='Supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="Manager" {{ old('role', $user->role)=='Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Investor" {{ old('role', $user->role)=='Investor' ? 'selected' : '' }}>Investor</option>
                   
                </select>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="active" {{ old('status', $user->status)=='active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status)=='inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="disabled" {{ old('status', $user->status)=='disabled' ? 'selected' : '' }}>Disabled</option>
                    <option value="pending" {{ old('status', $user->status)=='pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <!-- Gender -->
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="" {{ old('gender', $user->gender)=='' ? 'selected' : '' }}>Select</option>
                    <option value="male" {{ old('gender', $user->gender)=='male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $user->gender)=='female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- City -->
            <div class="col-md-6">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $user->city) }}">
            </div>

            <!-- State -->
            <div class="col-md-6">
                <label for="state" class="form-label">State / Country</label>
                <input type="text" id="state" name="state" class="form-control" value="{{ old('state', $user->state) }}">
            </div>

            <!-- Last Login (readonly) -->
            <div class="col-md-6">
                <label class="form-label">Last Login</label>
                <input type="text" class="form-control" value="{{ $user->last_login ?? '—' }}" readonly>
            </div>

            <!-- Last Activity (readonly) -->
            <div class="col-md-6">
                <label class="form-label">Last Activity</label>
                <input type="text" class="form-control" value="{{ $user->last_activity ?? '—' }}" readonly>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('manager.pending.users') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- JS Preview الصورة -->
<script>
    const profileImage = document.getElementById('profileImage');
    const profilePreview = document.getElementById('profilePreview');

    profileImage.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
