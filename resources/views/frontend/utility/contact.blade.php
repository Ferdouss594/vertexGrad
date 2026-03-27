@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                Get in <span class="text-brand-accent">Touch</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-xl mx-auto">
                Have questions about submitting a project, investing, or becoming a vetting partner?
            </p>
        </header>

        <div class="theme-panel p-10 rounded-2xl">
            <form action="/contact" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-theme-muted mb-2">Your Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-theme-muted mb-2">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                        >
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-theme-muted mb-2">Subject</label>
                    <select
                        id="subject"
                        name="subject"
                        required
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text focus:ring-0 focus:border-brand-accent"
                    >
                        <option value="" disabled selected>Select the nature of your inquiry</option>
                        <option value="academic">Academic Submission Inquiry</option>
                        <option value="investor">Investor / Funding Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="other">Other / General Inquiry</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-theme-muted mb-2">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface-2 text-theme-text placeholder:text-theme-muted focus:ring-0 focus:border-brand-accent"
                    ></textarea>
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg px-6 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                    >
                        Send Message
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection