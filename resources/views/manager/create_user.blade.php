@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- رسائل النجاح والخطأ -->


    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New User</h4>
        </div>
        <div class="card-body">

            <!-- نموذج واحد فقط -->
            <form action="{{ route('manager.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Image Circle -->
                <div class="text-center mb-4">
                    <div style="position: relative; display: inline-block; width: 150px; height: 150px;">
                        <img id="imagePreview" src="{{ asset('src/images/avatar.png') }}" 
                            alt="Profile Preview" 
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                        
                        <label for="profileImage" 
                            style="position: absolute; bottom: -10px; right: -10px; 
                                   width: 50px; height: 50px; background-color: #5bc0de; 
                                   color: white; border-radius: 50%; display: flex; 
                                   justify-content: center; align-items: center; 
                                   cursor: pointer; font-weight: bold; font-size: 24px;">
                            +
                        </label>
                        <input type="file" name="profile_image" id="profileImage" class="d-none" accept="image/*">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="Student">Student</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Manager">Manager</option>
                            <option value="Investor">Investor</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending" selected>Pending</option>
                            <option value="disabled">Disabled</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">State / Country</label>
                        <input type="text" name="state" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn px-5 py-2" style="background-color: #003366; color: white; font-weight: bold;">
                        Add User
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- JS for Image Preview -->
<script>
    const profileImage = document.getElementById('profileImage');
    const imagePreview = document.getElementById('imagePreview');

    profileImage.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "{{ asset('src/images/avatar.png') }}";
        }
    });
</script>
@endsection
