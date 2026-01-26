@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="text-center mb-16">
            <h1 class="text-6xl font-extrabold text-light mb-4">
                The VertexGrad <span class="text-primary">Process</span>
            </h1>
            <p class="text-xl text-light/80 max-w-3xl mx-auto">
                Connecting world-class research to institutional funding in four clear stages.
            </p>
        </header>

        {{-- Process Timeline --}}
        <div class="space-y-12 relative">
            <div class="absolute left-1/2 w-0.5 bg-primary/30 h-full transform -translate-x-1/2"></div>
            
            {{-- Step 1: Submission --}}
            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">1</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-light mb-2">Academic Submission</h3>
                    <p class="text-light/80">
                        Researchers submit detailed proposals, IP forms, and team bios through our guided 4-step process. Submissions are saved as drafts and kept confidential.
                    </p>
                </div>
            </div>

            {{-- Step 2: Vetting --}}
            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">2</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-light mb-2">Expert Vetting & Diligence</h3>
                    <p class="text-light/80">
                        Our administrative team and third-party specialists review feasibility, market potential, and legal compliance (IP clearance, institutional sign-off).
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>

            {{-- Step 3: Exposure --}}
            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">3</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-light mb-2">Investor Exposure</h3>
                    <p class="text-light/80">
                        Vetted projects are added to the Investment Pipeline, visible only to verified and accredited Investor Accounts based on their stated investment mandate.
                    </p>
                </div>
            </div>
            
            {{-- Step 4: Funding --}}
            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">4</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-light mb-2">Deal Finalization</h3>
                    <p class="text-light/80">
                        Investors express interest, initiating a confidential Due Diligence period leading to direct negotiation and final investment agreement outside the platform.
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>
        </div>
        
    </div>
</div>
@endsection