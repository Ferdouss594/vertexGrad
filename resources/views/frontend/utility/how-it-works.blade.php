@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-16">
            <h1 class="text-6xl font-extrabold text-light mb-4">
                {{ __('frontend.process.title_before') }}
                <span class="text-primary">{{ __('frontend.process.title_highlight') }}</span>
            </h1>
            <p class="text-xl text-light/80 max-w-3xl mx-auto">
                {{ __('frontend.process.subtitle') }}
            </p>
        </header>

        <div class="space-y-12 relative">
            <div class="absolute left-1/2 w-0.5 bg-primary/30 h-full transform -translate-x-1/2"></div>

            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">1</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-light mb-2">{{ __('frontend.process.step1_title') }}</h3>
                    <p class="text-light/80">
                        {{ __('frontend.process.step1_text') }}
                    </p>
                </div>
            </div>

            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">2</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-light mb-2">{{ __('frontend.process.step2_title') }}</h3>
                    <p class="text-light/80">
                        {{ __('frontend.process.step2_text') }}
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>

            <div class="relative flex justify-start md:justify-around items-center">
                <div class="hidden md:block w-5/12"></div>
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">3</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg ml-10 md:ml-0 md:mr-10">
                    <h3 class="text-2xl font-semibold text-light mb-2">{{ __('frontend.process.step3_title') }}</h3>
                    <p class="text-light/80">
                        {{ __('frontend.process.step3_text') }}
                    </p>
                </div>
            </div>

            <div class="relative flex justify-end md:justify-around items-center">
                <div class="absolute w-8 h-8 rounded-full bg-primary border-4 border-dark z-10 left-1/2 transform -translate-x-1/2 flex items-center justify-center text-light font-bold">4</div>
                <div class="w-full md:w-5/12 bg-cardLight/70 p-6 rounded-xl border border-primary/30 shadow-lg mr-10 md:mr-0 md:ml-10 order-2 md:order-1">
                    <h3 class="text-2xl font-semibold text-light mb-2">{{ __('frontend.process.step4_title') }}</h3>
                    <p class="text-light/80">
                        {{ __('frontend.process.step4_text') }}
                    </p>
                </div>
                <div class="hidden md:block w-5/12 order-1 md:order-2"></div>
            </div>
        </div>

    </div>
</div>
@endsection