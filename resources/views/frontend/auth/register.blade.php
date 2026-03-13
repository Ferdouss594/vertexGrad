@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-5xl p-4 lg:p-8 text-center">
        
        <h2 class="text-5xl font-extrabold text-light mb-4">
            Join the <span class="text-primary">VertexGrad</span> Ecosystem
        </h2>
        <p class="text-xl text-light/70 mb-16 max-w-3xl mx-auto">
            Please select the user type that applies to you to continue the registration process.
        </p>

        {{-- 🟢 ADDED: Message/Error Logic --}}
        @if ($errors->any())
            <div class="max-w-md mx-auto mb-8 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- 🟢 END MESSAGE LOGIC --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Path 1: INVESTOR --}}
            <a href="{{ route('register.investor') }}" class="p-10 rounded-2xl border border-primary/30 bg-cardLight/50 hover:bg-cardLight/70 transition duration-300 shadow-neon_md block group">
                <i class="fas fa-hand-holding-usd text-6xl text-primary mb-4 group-hover:drop-shadow-neon_sm"></i>
                <h3 class="text-3xl font-bold text-light mb-3">Investor / Fund Manager</h3>
                <p class="text-light/70 mb-6">
                    Gain exclusive access to faculty-vetted project proposals and secure funding opportunities.
                </p>
                <span class="{{ $btnPrimaryClass }} !bg-primary/20 text-primary border border-primary group-hover:bg-primary/40">
                    Register as Investor <i class="fas fa-arrow-right ml-2"></i>
                </span>
            </a>

            {{-- Path 2: ACADEMIC / STUDENT --}}
            <a href="{{ route('register.academic') }}" class="p-10 rounded-2xl border border-primary/30 bg-cardLight/50 hover:bg-cardLight/70 transition duration-300 shadow-neon_md block group">
                <i class="fas fa-flask text-6xl text-light/80 mb-4 group-hover:text-primary"></i>
                <h3 class="text-3xl font-bold text-light mb-3">Academic / Project Creator</h3>
                <p class="text-light/70 mb-6">
                    Submit your innovation for rigorous vetting and connect directly with institutional capital.
                </p>
                <span class="{{ $btnSecondaryClass }} !border-primary/50 text-light group-hover:text-primary group-hover:border-primary">
                    Register as Academic <i class="fas fa-rocket ml-2"></i>
                </span>
            </a>
            
        </div>

        <p class="mt-12 text-center text-light/60 text-sm">
            Already have an account?
            <a href="{{ route('login.show') }}" class="text-primary hover:text-light font-medium ml-1">
                Log In
            </a>
        </p>
    </div>
</div>
@endsection