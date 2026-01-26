@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-light mb-4">
                Privacy <span class="text-primary">Policy</span>
            </h1>
            <p class="text-sm text-light/60">
                Effective Date: January 1, 2026
            </p>
        </header>

        <div class="bg-cardLight/70 p-10 rounded-xl border border-light/20 shadow-xl space-y-8 text-light/80">
            
            <section>
                <h3 class="text-3xl font-semibold text-primary mb-4">1. Information We Collect</h3>
                <p>
                    We collect personal identification information from Academics (institutional affiliation, research data summary) and Investors (accreditation status, fund size). This is primarily used for verification and matching purposes.
                </p>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-primary mb-4">2. How We Use Your Data</h3>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>To verify user identity and prevent fraud.</li>
                    <li>To facilitate introductions between Investors and Vetted Projects.</li>
                    <li>To send platform updates and security alerts.</li>
                    <li>We never sell your personal information to third parties.</li>
                </ul>
            </section>

            <section>
                <h3 class="text-3xl font-semibold text-primary mb-4">3. Data Security</h3>
                <p>
                    We implement a variety of security measures, including encryption and two-factor authentication, to maintain the safety of your personal information. Sensitive data, like financial details or non-public research abstracts, are stored in encrypted databases.
                </p>
            </section>
        </div>

    </div>
</div>
@endsection