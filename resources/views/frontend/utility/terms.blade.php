@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                Terms of <span class="text-brand-accent">Service</span>
            </h1>
            <p class="text-sm text-theme-muted">
                Last updated: December 12, 2025
            </p>
        </header>

        <div class="theme-panel p-10 rounded-xl space-y-8 text-theme-muted">
            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">1. Acceptance of Terms</h3>
                <p>
                    By accessing or using the VertexGrad platform ("Service"), you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the Service. This platform is intended for use by accredited investors and university-affiliated academic researchers only.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">2. User Responsibilities (Academics)</h3>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>All submitted data must be accurate, non-confidential, and legally permissible for sharing.</li>
                    <li>The Principal Investigator (PI) guarantees that all necessary institutional approvals (IRB, etc.) have been secured.</li>
                    <li>IP ownership remains with the Institution/PI, but submission grants VertexGrad limited rights to vet and showcase the proposal.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">3. Investor Obligations</h3>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Investors must be accredited and acknowledge the high-risk nature of seed-stage academic investment.</li>
                    <li>All information viewed on the platform is highly confidential and must not be shared externally.</li>
                    <li>VertexGrad acts as a connector; final investment decisions and due diligence are the sole responsibility of the investor.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">4. Limitation of Liability</h3>
                <p>
                    VertexGrad is not liable for any financial losses, damages, or disputes arising from any investment or funding relationship facilitated through the Service. The Service is provided "as is."
                </p>
            </section>
        </div>

    </div>
</div>
@endsection