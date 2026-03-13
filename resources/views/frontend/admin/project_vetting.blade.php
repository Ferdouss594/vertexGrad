@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnDangerClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_danger'];
    $cardBg = '#1E293B';
    
    // Placeholder Project Data for Review
    $project = [
        'id' => 104,
        'title' => 'Advanced Robotics for Agriculture',
        'lead' => 'Dr. Elias Thorne',
        'institution' => 'Wageningen University & Research',
        'funding' => '850,000',
        'duration' => 18, // months
        'status' => 'Pending Review',
        'abstract' => 'Development of swarm robotics specialized in selective micro-weeding and soil analysis, drastically reducing chemical use and increasing yield stability in complex terrains. Technology leverages proprietary deep learning models for plant health identification.'
    ];
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-8 border-b border-light/20 pb-4">
            <a href="/admin/dashboard" class="text-sm text-primary hover:text-light/80"><i class="fas fa-arrow-left mr-2"></i> Back to Admin Dashboard</a>
            <h1 class="text-4xl font-extrabold text-light mt-2">
                Project Vetting: #{{ $project['id'] }} - {{ $project['title'] }}
            </h1>
            <p class="text-xl text-warning mt-1">Current Status: {{ $project['status'] }}</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- 1. Project Details (2/3 width) --}}
            <section class="lg:col-span-2 space-y-6">
                
                {{-- Abstract/Summary --}}
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-2xl font-semibold text-primary mb-3">Project Summary</h3>
                    <p class="text-light/80 leading-relaxed">{{ $project['abstract'] }}</p>
                    <div class="mt-4 pt-4 border-t border-light/10 text-sm text-light/70">
                        <p><strong class="text-light">Discipline:</strong> Robotics / AI</p>
                    </div>
                </div>

                {{-- Team and Financials --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                        <h3 class="text-2xl font-semibold text-primary mb-3">Principal Investigator</h3>
                        <p class="text-light text-lg">{{ $project['lead'] }}</p>
                        <p class="text-light/70">{{ $project['institution'] }}</p>
                    </div>
                    <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                        <h3 class="text-2xl font-semibold text-primary mb-3">Investment Request</h3>
                        <p class="text-success text-3xl font-bold">${{ number_format($project['funding']) }}</p>
                        <p class="text-light/70">{{ $project['duration'] }} Months Duration</p>
                    </div>
                </div>

                {{-- Documents and Files --}}
                <div class="bg-cardLight/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-2xl font-semibold text-primary mb-4">Supporting Documents</h3>
                    <ul class="space-y-3 text-primary">
                        <li><i class="fas fa-file-pdf mr-2"></i> <a href="#">Full Budget Breakdown (Required)</a></li>
                        <li><i class="fas fa-file-alt mr-2"></i> <a href="#">Technical Whitepaper V1.0</a></li>
                        <li><i class="fas fa-file-alt mr-2"></i> <a href="#">PI Curriculum Vitae (CV)</a></li>
                    </ul>
                </div>
                
            </section>
            
            {{-- 2. Vetting Action Panel (1/3 width) --}}
            <aside class="lg:col-span-1 space-y-6">
                
                {{-- Decision Form --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-primary/50 shadow-xl">
                    <h3 class="text-2xl font-semibold text-light mb-4">Vetting Decision</h3>
                    
                    <form action="/admin/projects/{{ $project['id'] }}/decision" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-light/80 mb-2">Change Status To:</label>
                            <select id="status" name="status" required 
                                    class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                                <option value="Pending Review" selected>Pending Review</option>
                                <option value="Vetted">Vetted (Ready for Investor Pipeline)</option>
                                <option value="Needs Revision">Needs Revision (Send Back to PI)</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label for="feedback" class="block text-sm font-medium text-light/80 mb-2">Internal Notes / Feedback to PI</label>
                            <textarea id="feedback" name="feedback" rows="4" placeholder="Enter reason for rejection or areas needing revision..."
                                      class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary"></textarea>
                        </div>

                        <button type="submit" class="{{ $btnPrimaryClass }} w-full py-3 mb-3">
                            <i class="fas fa-sync-alt mr-2"></i> Finalize Status Change
                        </button>
                    </form>
                </div>

                {{-- Quick Vetting Checklist --}}
                <div class="bg-dark/70 p-6 rounded-xl border border-light/20 shadow-lg">
                    <h3 class="text-2xl font-semibold text-light mb-4">Internal Checklist</h3>
                    <ul class="space-y-2 text-light/80">
                        <li><i class="fas fa-check-circle text-success mr-2"></i> IP Clearance Confirmed</li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i> Budget vs. Industry Standard (OK)</li>
                        <li><i class="fas fa-times-circle text-danger mr-2"></i> Team Experience Vetted (Needs CV)</li>
                        <li><i class="fas fa-question-circle text-warning mr-2"></i> Milestone Clarity (Re-check Month 12)</li>
                    </ul>
                </div>
                
            </aside>
            
        </div>

    </div>
</div>
@endsection