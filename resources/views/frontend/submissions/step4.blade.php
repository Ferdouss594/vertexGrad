@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2">Step 4 of 5: Account & Confirmation</h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 80%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2">Account Setup and Submission Confirmation</h2>
        <p class="text-lg text-theme-muted mb-10">
            Create your account or confirm your details so you can track the project status after submission and technical scanning.
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.step4.post') }}" method="POST" class="space-y-8">
            @csrf

            <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                <h4 class="text-2xl font-semibold text-brand-accent mb-4">Account Information</h4>
                <p class="text-sm text-theme-muted mb-6">
                    Use a valid email address to follow your project, receive scan updates, and continue submission later.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-theme-muted mb-2">
                            Email Address <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            value="{{ old('email', session('user_data.email')) }}"
                            placeholder="example@email.com"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-theme-muted mb-2">
                            Password <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-theme-muted mb-2">
                            Confirm Password <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>
                </div>
            </div>

            <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                <h4 class="text-2xl font-semibold text-brand-accent mb-4">Submission Confirmation</h4>

                <div class="space-y-4">
                    <label class="flex items-start text-theme-text">
                        <input
                            type="checkbox"
                            name="data_confirmation"
                            value="1"
                            required
                            class="form-checkbox h-5 w-5 mt-1 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"
                        >
                        <span class="ml-3 text-sm leading-6">
                            I confirm that the information entered about the project is correct and reflects the actual academic work submitted.
                        </span>
                    </label>

                    <label class="flex items-start text-theme-text">
                        <input
                            type="checkbox"
                            name="terms_agreement"
                            value="1"
                            required
                            class="form-checkbox h-5 w-5 mt-1 text-brand-accent border-theme-border bg-theme-surface rounded focus:ring-brand-accent"
                        >
                        <span class="ml-3 text-sm leading-6">
                            I agree to the
                            <a href="/terms" target="_blank" class="text-brand-accent underline">Terms & Conditions</a>
                            and understand that the project will first pass through technical scanning and administrative review before publishing.
                        </span>
                    </label>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <a
                    href="{{ route('project.submit.step3') }}"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300"
                >
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                >
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection