<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | VertexGrad</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">
    <style>
        .text-danger {
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .login-box {
            margin-top: 40px;
        }
        .select-role {
            margin-bottom: 15px;
        }
        .btn-group-toggle .btn {
            border: 1px solid #ddd;
            padding: 10px 20px;
            margin-right: 5px;
            border-radius: 6px;
        }
        .btn.active {
            background-color: #1b00ff;
            color: #fff;
        }
    </style>
</head>
<body class="login-page">

    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ route('admin.login.show') }}">
                    <img src="{{ asset('vendors/images/VertexGrad_logoud.png') }}" alt="" class="light-logo" style="margin-top:13px;">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="{{ route('admin.register.show') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('vendors/images/login-page-img.png') }}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10 p-4">

                        <!-- Login Form -->
                        <div id="login-form">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Login to VertexGrad</h2>
                            </div>

                            <form action="{{ route('admin.login.post') }}" method="POST">
                                @csrf

                                <!-- Role Selection -->
                                <div class="select-role text-center mb-3">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn {{ old('role') == 'Manager' ? 'active' : '' }}">
                                            <input type="radio" name="role" value="Manager" {{ old('role') == 'Manager' ? 'checked' : '' }}>
                                            <div class="icon">
                                                <img src="{{ asset('vendors/images/briefcase.svg') }}" class="svg" alt="">
                                            </div>
                                            <span>I'm</span> Manager
                                        </label>
                                        <label class="btn {{ old('role') == 'Supervisor' ? 'active' : '' }}">
                                            <input type="radio" name="role" value="Supervisor" {{ old('role') == 'Supervisor' ? 'checked' : '' }}>
                                            <div class="icon">
                                                <img src="{{ asset('vendors/images/person.svg') }}" class="svg" alt="">
                                            </div>
                                            <span>I'm</span> Supervisor
                                        </label>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Login ID -->
                                <div class="input-group custom mt-3">
                                    <input type="text" name="login_id" class="form-control form-control-lg" placeholder="Email or Username" value="{{ old('login_id') }}">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                </div>
                                @error('login_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Password -->
                                <div class="input-group custom mt-3">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="**********">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <!-- Remember + Forgot -->
                                <div class="row pb-30 mt-3">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember</label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="#" id="forgot-password-toggle">Forgot Password?</a>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
                                        <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                        <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('admin.register.show') }}">Register to Create Account</a>
                                    </div>
                                </div>

                                @if(session('error'))
                                    <div class="text-danger mt-2 text-center">{{ session('error') }}</div>
                                @endif
                            </form>
                        </div>

                        <!-- Forgot Password Form -->
                        <div id="forgot-password-form" style="display:none;">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Reset Password</h2>
                                <p class="text-center">Enter your email to receive a reset link</p>
                            </div>

                            @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-group custom mt-3">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Your Email" required>
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Send Reset Link</button>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="#" id="back-to-login">Back to Login</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>

    <script>
        // Toggle Forgot Password Form
        document.getElementById('forgot-password-toggle').addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('forgot-password-form').style.display = 'block';
        });

        document.getElementById('back-to-login').addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById('forgot-password-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        });
    </script>
</body>
</html>
