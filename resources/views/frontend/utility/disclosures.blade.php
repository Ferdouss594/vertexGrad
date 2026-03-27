@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                Platform <span class="text-brand-accent">Disclosures</span>
            </h1>
            <p class="text-sm text-theme-muted">
                Important information for academics, institutions, and investors
            </p>
        </header>

        <div class="theme-panel p-10 rounded-xl space-y-8 text-theme-muted">

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">1. Platform Role</h3>
                <p>
                    VertexGrad acts as a facilitation and discovery platform connecting vetted academic projects with qualified investors and institutional partners. VertexGrad does not act as a broker-dealer, investment adviser, legal representative, or fiduciary for either party unless explicitly stated in a separate written agreement.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">2. No Investment Guarantee</h3>
                <p>
                    Inclusion of a project on the platform does not guarantee investor interest, funding, commercialization success, or future market viability. All investment decisions involve risk, including the potential loss of capital.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">3. Academic & Institutional Responsibility</h3>
                <p>
                    Researchers, founders, and affiliated institutions are solely responsible for ensuring that submitted materials are accurate, lawfully shareable, and compliant with internal university rules, intellectual property requirements, ethics approvals, and disclosure obligations.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">4. Investor Responsibility</h3>
                <p>
                    Investors are responsible for conducting their own independent due diligence, legal review, financial analysis, and technical validation before entering any funding arrangement. VertexGrad does not guarantee the completeness or suitability of any listed opportunity.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">5. Confidentiality & Information Use</h3>
                <p>
                    Some information displayed on the platform may be confidential, limited, or shared for evaluation purposes only. Users must not redistribute, copy, or disclose project materials outside approved workflows or without proper authorization.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-brand-accent mb-4">6. Regulatory & Legal Notice</h3>
                <p>
                    Users are responsible for determining whether their participation on the platform is subject to securities laws, institutional regulations, export controls, privacy rules, or any other local or international legal requirements. VertexGrad recommends that all parties seek independent legal and financial advice where appropriate.
                </p>
            </section>

        </div>

    </div>
</div>
@endsection