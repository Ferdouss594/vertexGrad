@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-16">
            <h1 class="text-6xl font-extrabold text-theme-text mb-4">
                The VertexGrad <span class="text-brand-accent">Process</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-3xl mx-auto">
                Connecting world-class research to institutional funding in four clear stages.
            </p>
        </header>

        <div class="space-y-12 relative">
            <div class="absolute left-1/2 w-0.5 bg-brand-accent/30 h-full transform -translate-x-1/2 hidden md:block"></div>

            {{-- Step 1 --}}
            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">
                    1
                </div>
                <div class="w-full md:w-5/12 theme-panel p-6 rounded-xl ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-theme-text mb-2">Academic Submission</h3>
                    <p class="text-theme-muted">
                        Researchers submit detailed proposals, IP forms, and team bios through our guided 4-step process. Submissions are saved as drafts and kept confidential.
                    </p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">
                    2
                </div>
                <div class="w-full md:w-5/12 theme-panel p-6 rounded-xl mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-theme-text mb-2">Expert Vetting & Diligence</h3>
                    <p class="text-theme-muted">
                        Our administrative team and third-party specialists review feasibility, market potential, and legal compliance (IP clearance, institutional sign-off).
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>

            {{-- Step 3 --}}
            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">
                    3
                </div>
                <div class="w-full md:w-5/12 theme-panel p-6 rounded-xl ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-theme-text mb-2">Investor Exposure</h3>
                    <p class="text-theme-muted">
                        Vetted projects are added to the Investment Pipeline, visible only to verified and accredited Investor Accounts based on their stated investment mandate.
                    </p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-brand-accent border-4 border-theme-bg z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-white font-bold">
                    4
                </div>
                <div class="w-full md:w-5/12 theme-panel p-6 rounded-xl mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-theme-text mb-2">Deal Finalization</h3>
                    <p class="text-theme-muted">
                        Investors express interest, initiating a confidential Due Diligence period leading to direct negotiation and final investment agreement outside the platform.
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>
        </div>

    </div>
</div>
@endsection