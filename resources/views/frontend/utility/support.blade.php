@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-20 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-theme-text mb-4">
                Support & <span class="text-brand-accent">FAQ</span>
            </h1>
            <p class="text-xl text-theme-muted max-w-2xl mx-auto">
                Find answers quickly. If you can't find what you need, please use our
                <a href="/contact" class="text-brand-accent hover:underline">Contact Form</a>.
            </p>
        </header>

        <div class="space-y-6">
            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    Is there a fee to submit research?
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    No. There is no cost for Academic PIs to submit their research. VertexGrad only charges a small percentage fee (typically 5%) on the funding amount if a successful investment deal is closed through the platform.
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    How do you verify Investor Accounts?
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    All investors must provide proof of accreditation (e.g., net worth verification, regulatory filings) which is reviewed by our legal and compliance team before granting access to the Investment Pipeline.
                </p>
            </div>

            <div class="theme-panel p-6 rounded-xl group cursor-pointer">
                <h3 class="text-xl font-semibold text-theme-text mb-2 flex justify-between items-center">
                    What happens to my IP during the vetting process?
                    <i class="fas fa-chevron-down text-brand-accent group-hover:rotate-180 transition-transform"></i>
                </h3>
                <p class="text-theme-muted mt-2 hidden group-hover:block transition-all duration-300">
                    Your Intellectual Property (IP) remains with your institution. We only share non-confidential summaries for initial review. Confidential documents are shared only after an Investor signs a separate NDA initiated through the platform.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection