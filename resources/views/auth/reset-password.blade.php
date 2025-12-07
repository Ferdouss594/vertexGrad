@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10 p-4">
                    <div class="login-title text-center">
                        <h2 class="text-primary">Reset Password</h2>
                        <p>Enter your new password below</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="input-group custom mt-3">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required value="{{ old('email') }}">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>

                        <div class="input-group custom mt-3">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="New Password" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>

                        <div class="input-group custom mt-3">
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login.show') }}">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
