@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                {{ __('frontend.contact.title_before') }}
                <span class="text-brand-accent">{{ __('frontend.contact.title_highlight') }}</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-xl mx-auto">
                {{ __('frontend.contact.subtitle') }}
            </p>
        </header>

        <div class="theme-panel p-10 rounded-2xl">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-600">
                    <p class="font-semibold mb-2">{{ __('frontend.contact.fix_issues') }}</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('utility.contact.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.contact.name') }}
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', auth('web')->check() ? auth('web')->user()->name : '') }}"
                            required
                            maxlength="100"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                            placeholder="{{ __('frontend.contact.name_placeholder') }}"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-theme-muted mb-2">
                            {{ __('frontend.contact.email') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', auth('web')->check() ? auth('web')->user()->email : '') }}"
                            required
                            maxlength="150"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                            placeholder="{{ __('frontend.contact.email_placeholder') }}"
                        >
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-theme-muted mb-2">
                        {{ __('frontend.contact.subject') }}
                    </label>
                    <select
                        id="subject"
                        name="subject"
                        required
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                    >
                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>
                            {{ __('frontend.contact.subject_placeholder') }}
                        </option>
                        <option value="academic" {{ old('subject') === 'academic' ? 'selected' : '' }}>
                            {{ __('frontend.contact.subject_academic') }}
                        </option>
                        <option value="investor" {{ old('subject') === 'investor' ? 'selected' : '' }}>
                            {{ __('frontend.contact.subject_investor') }}
                        </option>
                        <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>
                            {{ __('frontend.contact.subject_support') }}
                        </option>
                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>
                            {{ __('frontend.contact.subject_other') }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-theme-muted mb-2">
                        {{ __('frontend.contact.message') }}
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        maxlength="5000"
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                        placeholder="{{ __('frontend.contact.message_placeholder') }}"
                    >{{ old('message') }}</textarea>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        {{ __('frontend.contact.send') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection