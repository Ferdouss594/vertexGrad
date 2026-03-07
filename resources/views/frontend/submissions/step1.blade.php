@php
    $design = config('design');
    $darkBg = $design['colors']['dark'];
    $primaryColor = $design['colors']['primary'];
    $btnPrimaryClass = $design['classes']['btn_base'] . ' ' . $design['classes']['btn_primary'];
    $cardBg = '#1E293B';
@endphp

@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16" style="background-color: {{ $darkBg }};">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl border border-primary/30
                shadow-[0_0_50px_rgba(30,227,247,0.2)]"
           style="background-color: {{ $cardBg }};">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-light mb-2">Step 1 of 4: Project Overview</h3>
            <div class="h-2 bg-dark rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width: 25%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-light mb-2">Submit Your Innovation</h2>
        <p class="text-lg text-light/70 mb-10">Tell us about the core idea and provide media.</p>

        {{-- Use route (clean) --}}
<form action="{{ route('project.submit.step1.post') }}" method="POST" enctype="multipart/form-data">
               @csrf

            <div>
                <label for="project_title" class="block text-sm font-medium text-light/80 mb-2">
                    Project Title <span class="text-primary">*</span>
                </label>
                <input type="text" id="project_title" name="project_title" required
                        value="{{ session('project_data.project_title') }}"
                        placeholder="e.g., Quantum Machine Learning for Drug Discovery"
                        class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label for="abstract" class="block text-sm font-medium text-light/80 mb-2">
                    Abstract / Summary <span class="text-primary">*</span>
                </label>
                <textarea id="abstract" name="abstract" required rows="6"
                          placeholder="Provide a concise summary..."
                          class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light placeholder-light/50 focus:ring-primary focus:border-primary">{{ session('project_data.abstract') }}</textarea>
            </div>

            <div>
                <label for="discipline" class="block text-sm font-medium text-light/80 mb-2">
                    Primary Academic Discipline <span class="text-primary">*</span>
                </label>
                {{-- IMPORTANT: values match your frontend filters --}}
            <select id="discipline" name="discipline" required
                    class="w-full p-3 rounded-lg border border-primary/30 bg-dark text-light focus:ring-primary focus:border-primary">
                <option value="" disabled {{ session('project_data.discipline') ? '' : 'selected' }}>Select the main field of research</option>
                <option value="ai_ml"    {{ session('project_data.discipline')=='ai_ml' ? 'selected' : '' }}>Artificial Intelligence & Machine Learning</option>
                <option value="biotech"  {{ session('project_data.discipline')=='biotech' ? 'selected' : '' }}>Biotechnology & Life Sciences</option>
                <option value="materials"{{ session('project_data.discipline')=='materials' ? 'selected' : '' }}>Advanced Materials & Nanotech</option>
                <option value="energy"   {{ session('project_data.discipline')=='energy' ? 'selected' : '' }}>Renewable Energy & Sustainability</option>
                <option value="quantum"  {{ session('project_data.discipline')=='quantum' ? 'selected' : '' }}>Quantum Computing & Physics</option>
                <option value="aero"     {{ session('project_data.discipline')=='aero' ? 'selected' : '' }}>Aerospace & Robotics</option>
                <option value="other"    {{ session('project_data.discipline')=='other' ? 'selected' : '' }}>Other</option>
            </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-light/80 mb-2">Project Photo</label>
<input type="file" name="project_photos[]" accept="image/*" multiple
 class="w-full p-2 rounded-lg border border-primary/30 bg-dark text-light">                </div>
                <div>
                    <label class="block text-sm font-medium text-light/80 mb-2">Project Video</label>
                    <input type="file" name="project_video" accept="video/*"
                           class="w-full p-2 rounded-lg border border-primary/30 bg-dark text-light">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="{{ $btnPrimaryClass }} text-lg py-3 px-8 shadow-neon_sm">
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection