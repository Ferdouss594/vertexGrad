@php
    // Assuming design variables are available
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $btnDangerClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_danger'];
    $btnWarningClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_warning'];
    $cardBg = '#1E293B';
    
    // Placeholder Data for User List
    $users = [
        ['id' => 201, 'name' => 'Dr. Elias Thorne', 'email' => 'thorne@uni.edu', 'role' => 'Academic', 'status' => 'Active', 'projects' => 1],
        ['id' => 312, 'name' => 'Sarah V. Kim', 'email' => 'sarah.kim@vcfund.com', 'role' => 'Investor', 'status' => 'Unverified', 'projects' => 0],
        ['id' => 202, 'name' => 'Prof. S. Khan', 'email' => 'khan@eth.ch', 'role' => 'Academic', 'status' => 'Suspended', 'projects' => 3],
        ['id' => 313, 'name' => 'Global Ventures Inc.', 'email' => 'support@gvi.net', 'role' => 'Investor', 'status' => 'Active', 'projects' => 5],
    ];
@endphp

@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-8 border-b border-light/20 pb-4">
            <a href="/admin/dashboard" class="text-sm text-primary hover:text-light/80"><i class="fas fa-arrow-left mr-2"></i> Back to Admin Dashboard</a>
            <h1 class="text-4xl font-extrabold text-light mt-2">
                👥 User Management Console
            </h1>
            <p class="text-xl text-primary mt-1">Manage, verify, and monitor all platform accounts (Total: 497)</p>
        </header>

        {{-- Filters and Search --}}
        <div class="flex justify-between items-center mb-6 p-4 bg-card/50 rounded-xl border border-light/10">
            <div class="flex space-x-4">
                <select class="p-2 rounded-lg border border-primary/30 bg-dark text-light">
                    <option>Filter by Role: All</option>
                    <option>Role: Academic</option>
                    <option>Role: Investor</option>
                </select>
                <select class="p-2 rounded-lg border border-primary/30 bg-dark text-light">
                    <option>Filter by Status: All</option>
                    <option>Status: Unverified</option>
                    <option>Status: Active</option>
                    <option>Status: Suspended</option>
                </select>
            </div>
            <div class="relative w-1/3">
                <input type="text" placeholder="Search by Name or Email..." class="w-full p-2 rounded-lg border border-primary/30 bg-dark text-light">
                <i class="fas fa-search absolute right-3 top-2.5 text-light/50"></i>
            </div>
        </div>

        {{-- User Table --}}
        <div class="overflow-x-auto bg-card/70 rounded-xl shadow-2xl border border-primary/30">
            <table class="min-w-full divide-y divide-light/10">
                <thead class="bg-dark/70">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-light/70 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-light/70 uppercase tracking-wider">Name / Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-light/70 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-light/70 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-light/70 uppercase tracking-wider">Projects/Investments</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-light/70 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-light/10">
                    @foreach ($users as $user)
                    <tr class="hover:bg-dark/50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-light">{{ $user['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-medium text-light">{{ $user['name'] }}</p>
                            <p class="text-xs text-light/70">{{ $user['email'] }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($user['role'] == 'Academic') bg-primary/20 text-primary @else bg-success/20 text-success @endif">
                                {{ $user['role'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($user['status'] == 'Active') bg-success/20 text-success 
                                @elseif($user['status'] == 'Suspended') bg-danger/20 text-danger
                                @else bg-warning/20 text-warning @endif">
                                {{ $user['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light/80">{{ $user['projects'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            @if($user['status'] == 'Unverified')
                                <button class="{{ $btnWarningClass }} !py-1 !px-3 !text-xs">Verify</button>
                            @endif
                            <a href="/admin/users/{{ $user['id'] }}/edit" class="{{ $btnPrimaryClass }} !py-1 !px-3 !text-xs">Edit</a>
                            <button class="{{ $btnDangerClass }} !py-1 !px-3 !text-xs">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection