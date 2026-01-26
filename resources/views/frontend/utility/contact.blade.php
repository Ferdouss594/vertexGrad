@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-20" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-light mb-4">
                Get in <span class="text-primary">Touch</span>
            </h1>
            <p class="text-xl text-light/80 max-w-xl mx-auto">
                Have questions about submitting a project, investing, or becoming a vetting partner?
            </p>
        </header>

        <div class="bg-cardLight/70 p-10 rounded-2xl border border-primary/30 shadow-2xl">
            <form action="/contact" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-light/80 mb-2">Your Name</label>
                        <input type="text" id="name" name="name" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-light/80 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-light/80 mb-2">Subject</label>
                    <select id="subject" name="subject" required 
                            class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                        <option value="" disabled selected>Select the nature of your inquiry</option>
                        <option value="academic">Academic Submission Inquiry</option>
                        <option value="investor">Investor / Funding Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="other">Other / General Inquiry</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-light/80 mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" required 
                              class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full {{ $btnPrimaryClass }} text-lg py-3 shadow-neon_sm">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection