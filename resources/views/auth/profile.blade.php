@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- بطاقة المستخدم -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- صورة المستخدم -->
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('vendors/images/photo1.jpg') }}"
                         alt="User Avatar"
                         class="rounded-circle mb-3"
                         style="width:120px; height:120px; object-fit:cover; border:3px solid #0d6efd;">

                    <!-- اسم المستخدم -->
                    <h3 class="card-title">{{ $user->name }}</h3>

                    <!-- الدور -->
                    <p class="text-muted mb-1">{{ $user->role ?? 'User' }}</p>

                    <!-- البريد -->
                    <p class="mb-1"><i class="bi bi-envelope"></i> {{ $user->email }}</p>

                    <!-- رقم الهاتف -->
                    @if(isset($user->phone))
                        <p class="mb-1"><i class="bi bi-telephone"></i> {{ $user->phone }}</p>
                    @endif

                    <!-- أزرار -->
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
