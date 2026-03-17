@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnSecondaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_secondary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl border border-primary/30
                shadow-[0_0_50px_rgba(30,227,247,0.2)]"
         style="background-color: {{ $cardBg }};">

        {{-- Progress --}}
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 4 of 5: Account & Confirmation</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 80%;"></div>
            </div>
        </div>

        {{-- Heading --}}
        <h2 class="text-4xl font-bold text-light mb-2">Account Setup and Submission Confirmation</h2>
        <p class="text-lg text-light/70 mb-10">
            Create your account or confirm your details so you can track the project status after submission and technical scanning.
        </p>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.step4.post') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Account Credentials --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Account Information</h4>
                <p class="text-sm text-light/70 mb-6">
                    Use a valid email address to follow your project, receive scan updates, and continue submission later.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-light/80 mb-2">
                            Email Address <span class="text-primary">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            value="{{ old('email', session('user_data.email')) }}"
                            placeholder="example@email.com"
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-light/80 mb-2">
                            Password <span class="text-primary">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-light/80 mb-2">
                            Confirm Password <span class="text-primary">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"
                        >
                    </div>
                </div>
            </div>

            {{-- Confirmation Section --}}
            <div class="border border-light/10 p-6 rounded-lg bg-dark/50">
                <h4 class="text-2xl font-semibold text-primary mb-4">Submission Confirmation</h4>

                <div class="space-y-4">
                    <label class="flex items-start text-light/80">
                        <input
                            type="checkbox"
                            name="data_confirmation"
                            value="1"
                            required
                            class="form-checkbox h-5 w-5 mt-1 text-primary border-primary/30 bg-dark rounded focus:ring-primary"
                        >
                        <span class="ml-3 text-sm leading-6">
                            I confirm that the information entered about the project is correct and reflects the actual academic work submitted.
                        </span>
                    </label>

                    <label class="flex items-start text-light/80">
                        <input
                            type="checkbox"
                            name="terms_agreement"
                            value="1"
                            required
                            class="form-checkbox h-5 w-5 mt-1 text-primary border-primary/30 bg-dark rounded focus:ring-primary"
                        >
                        <span class="ml-3 text-sm leading-6">
                            I agree to the
                            <a href="/terms" target="_blank" class="text-primary underline">Terms & Conditions</a>
                            and understand that the project will first pass through technical scanning and administrative review before publishing.
                        </span>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-between pt-4">
                <a
                    href="{{ route('project.submit.step3') }}"
                    class="{{ $btnSecondaryClass }} text-lg py-3 px-8 border border-light/30 text-light/80 hover:text-primary"
                >
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button
                    type="submit"
                    class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm"
                >
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
