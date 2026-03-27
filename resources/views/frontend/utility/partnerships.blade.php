@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                Institutional <span class="text-brand-accent">Partnerships</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-3xl mx-auto">
                Collaborate with VertexGrad to streamline the commercialization of research from your university or incubator.
            </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="theme-panel p-6 rounded-xl text-center">
                <i class="fas fa-university text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">University Fast-Track</h3>
                <p class="text-theme-muted text-sm">
                    Dedicated pipeline and compliance checks for institutions to submit research deals directly to our vetting pool.
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl text-center">
                <i class="fas fa-lock text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">Joint Due Diligence</h3>
                <p class="text-theme-muted text-sm">
                    Work with our expert network to co-vet projects and mitigate risk before they are exposed to general investors.
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl text-center">
                <i class="fas fa-bullseye text-4xl text-brand-accent mb-4"></i>
                <h3 class="text-2xl font-semibold text-theme-text mb-2">Curated Deal Flow</h3>
                <p class="text-theme-muted text-sm">
                    For corporate VCs, we offer personalized deal sourcing based on specific technology and market requirements.
                </p>
            </div>
        </div>

        <div class="mt-16 text-center">
            <h2 class="text-4xl font-bold text-theme-text mb-4">Ready to Partner?</h2>
            <p class="text-xl text-theme-muted mb-8">
                Reach out to our Business Development team to discuss a custom partnership agreement.
            </p>

            <a href="/contact"
               class="inline-flex items-center justify-center rounded-lg px-10 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft">
                Start the Conversation <i class="fas fa-envelope ml-3"></i>
            </a>
        </div>

    </div>
</div>
@endsection