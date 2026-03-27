@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl p-4 lg:p-8 text-center">

        <h2 class="text-5xl font-extrabold text-theme-text mb-4">
            Join the <span class="text-brand-accent">VertexGrad</span> Ecosystem
        </h2>

        <p class="text-xl text-theme-muted mb-16 max-w-3xl mx-auto">
            Please select the user type that applies to you to continue the registration process.
        </p>

        @if ($errors->any())
            <div class="max-w-md mx-auto mb-8 p-4 rounded-lg bg-red-500/10 border border-red-400/40 text-red-500 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- INVESTOR --}}
            <a href="{{ route('register.investor') }}"
               class="p-10 rounded-2xl theme-panel hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group">
                <i class="fas fa-hand-holding-usd text-6xl text-brand-accent mb-4"
                   style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

                <h3 class="text-3xl font-bold text-theme-text mb-3">
                    Investor / Fund Manager
                </h3>

                <p class="text-theme-muted mb-6">
                    Gain exclusive access to faculty-vetted project proposals and secure funding opportunities.
                </p>

                <span class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold bg-brand-accent text-white group-hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                    Register as Investor <i class="fas fa-arrow-right ml-2"></i>
                </span>
            </a>

            {{-- ACADEMIC --}}
            <a href="{{ route('register.academic') }}"
               class="p-10 rounded-2xl theme-panel hover:bg-theme-surface-2 transition duration-300 shadow-brand-soft block group">
                <i class="fas fa-flask text-6xl text-brand-accent mb-4"
                   style="filter: drop-shadow(0 0 8px var(--brand-accent-glow));"></i>

                <h3 class="text-3xl font-bold text-theme-text mb-3">
                    Academic / Project Creator
                </h3>

                <p class="text-theme-muted mb-6">
                    Submit your innovation for rigorous vetting and connect directly with institutional capital.
                </p>

                <span class="inline-flex items-center justify-center rounded-lg px-6 py-3 font-semibold border border-brand-accent text-theme-text group-hover:bg-brand-accent group-hover:text-white transition duration-300">
                    Register as Academic <i class="fas fa-rocket ml-2"></i>
                </span>
            </a>

        </div>

        <p class="mt-12 text-center text-theme-muted text-sm">
            Already have an account?
            <a href="{{ route('login.show') }}" class="text-brand-accent font-medium ml-1">
                Log In
            </a>
        </p>
    </div>
</div>
@endsection