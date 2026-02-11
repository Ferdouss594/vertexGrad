@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-lg p-10 rounded-2xl border border-primary/30 shadow-[0_0_50px_rgba(30,227,247,0.2)]" style="background-color: {{ $cardBg }};">

        <div class="text-center mb-8">
            <i class="fas fa-satellite-dish text-5xl text-primary mb-4 block" style="filter: drop-shadow(0 0 10px {{ $primaryColor }});"></i>
        </div>

        <h2 class="text-4xl font-bold text-center text-light mb-2">Sign In to <span class="text-primary">VertexGrad</span></h2>
        <p class="text-center text-light/70 mb-10">Securely access your academic and investment dashboards.</p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200 text-sm">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-light/80 mb-2">Username or Email</label>
                <input type="text" name="login_id" value="{{ old('login_id') }}" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-light/80 mb-2">Password</label>
                <input type="password" id="loginPassword" name="password" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light pr-10">
                <button type="button" onclick="togglePassword('loginPassword')" class="absolute right-3 top-10 text-light/50 hover:text-primary"><i class="fas fa-eye"></i></button>
            </div>

            <div>
                <label class="block text-sm font-medium text-light/80 mb-2">Login As</label>
                <select name="role" required class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light">
                    <option value="">Select role</option>
                    <option value="Student">Student</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Investor">Investor</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>

            {{-- 🟢 Professional Trait: Remember Me --}}
            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-light/70 cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-primary/30 bg-dark text-primary focus:ring-primary">
                    Remember Me
                </label>
                <a href="#" class="text-sm text-primary hover:underline">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full {{ $btnPrimaryClass }} text-lg py-3">Log In</button>
        </form>

        <p class="mt-8 text-center text-light/60 text-sm">
            Don’t have an account? <a href="{{ route('register.show') }}" class="text-primary underline">Register Here</a>
        </p>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = event.currentTarget.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection