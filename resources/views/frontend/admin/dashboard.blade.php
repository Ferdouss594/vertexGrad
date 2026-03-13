@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnDangerClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_danger'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for Admin Metrics
    $pendingProjects = 12;
    $totalInvestors = 185;
    $unverifiedUsers = 5;
    $totalFundedValue = '$25.7M';
    
    // Placeholder Data for Projects Needing Action
    $newProjects = [
        ['id' => 104, 'title' => 'Advanced Robotics for Agriculture', 'discipline' => 'Robotics', 'submitted' => '2 days ago'],
        ['id' => 105, 'title' => 'Sustainable Battery Chemistry', 'discipline' => 'Energy', 'submitted' => '1 day ago'],
    ];
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-10 border-b border-light/20 pb-4">
            <h1 class="text-4xl font-extrabold text-light">
                ⚙️ Admin Control Panel
            </h1>
            <p class="text-xl text-danger mt-1">Platform Health and Vetting Oversight</p>
        </header>

        {{-- Key Metrics (Widgets) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            {{-- Pending Projects --}}
            <div class="p-5 rounded-xl border border-warning/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">New Projects to Review</p>
                <p class="text-4xl font-bold text-warning mt-1">{{ $pendingProjects }}</p>
            </div>
            
            {{-- Total Investors --}}
            <div class="p-5 rounded-xl border border-primary/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Registered Investors</p>
                <p class="text-4xl font-bold text-primary mt-1">{{ $totalInvestors }}</p>
            </div>

            {{-- Total Funded Value --}}
            <div class="p-5 rounded-xl border border-success/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Total Capital Deployed</p>
                <p class="text-3xl font-bold text-success mt-1">{{ $totalFundedValue }}</p>
            </div>
            
            {{-- Unverified Users --}}
            <div class="p-5 rounded-xl border border-danger/20 bg-cardLight/50 text-center">
                <p class="text-sm text-light/80">Unverified Investor Accounts</p>
                <p class="text-4xl font-bold text-danger mt-1">{{ $unverifiedUsers }}</p>
            </div>
        </div>

        {{-- Action Sections --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Projects Needing Review --}}
            <div class="lg:col-span-2 bg-card/50 p-6 rounded-xl border border-warning/30">
                <h3 class="text-2xl font-semibold text-light mb-5 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-warning"></i> Urgent: Projects Awaiting Vetting
                </h3>

                <ul class="space-y-4">
                    @foreach ($newProjects as $project)
                        <li class="p-4 rounded-lg bg-dark/50 border border-light/10 flex justify-between items-center hover:bg-dark/70 transition duration-150">
                            <div>
                                <p class="text-lg font-semibold text-light">#{{ $project['id'] }}: {{ $project['title'] }}</p>
                                <p class="text-sm text-light/70 mt-1">{{ $project['discipline'] }} - Submitted: {{ $project['submitted'] }}</p>
                            </div>
                            <a href="/admin/projects/{{ $project['id'] }}/review" class="{{ $btnPrimaryClass }} !bg-warning py-2 px-4 !text-sm">
                                Start Review <i class="fas fa-clipboard-check ml-1"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="text-right mt-4">
                    <a href="/admin/projects/review" class="text-primary hover:underline text-sm">View All Pending Projects ({{ $pendingProjects }})</a>
                </div>
            </div>

            {{-- Quick Links & User Management --}}
            <div class="bg-card/50 p-6 rounded-xl border border-primary/30">
                <h3 class="text-2xl font-semibold text-light mb-4 flex items-center">
                    <i class="fas fa-tools mr-3 text-primary"></i> Management Tools
                </h3>
                
                <ul class="space-y-3">
                    <li>
                        <a href="/admin/users" class="{{ $btnSecondaryClass }} w-full text-center border-b border-light/10 block hover:text-warning">
                            <i class="fas fa-user-shield mr-2"></i> User & Account Control
                        </a>
                    </li>
                    <li>
                        <a href="/admin/settings" class="{{ $btnSecondaryClass }} w-full text-center border-b border-light/10 block hover:text-warning">
                            <i class="fas fa-cogs mr-2"></i> System Configuration
                        </a>
                    </li>
                    <li>
                        <a href="/admin/reports" class="{{ $btnSecondaryClass }} w-full text-center block hover:text-warning">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> Financial Reports
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection