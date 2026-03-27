@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen py-16 bg-theme-bg transition-colors duration-300">
    <div class="w-full max-w-4xl mx-auto p-10 rounded-2xl theme-panel shadow-brand-soft">

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-theme-text mb-2">Step 2 of 5: Academic Information</h3>
            <div class="h-2 bg-theme-surface-2 rounded-full overflow-hidden">
                <div class="h-full bg-brand-accent" style="width: 40%;"></div>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-theme-text mb-2">Academic and Institutional Information</h2>
        <p class="text-lg text-theme-muted mb-10">
            Enter the academic details related to the project, including the student, supervisor, and institution.
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/40 text-red-600 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.submit.step2.post') }}" method="POST" class="space-y-8">
            @csrf

            <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                <h4 class="text-2xl font-semibold text-brand-accent mb-4">Student Information</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="student_name" class="block text-sm font-medium text-theme-muted mb-2">
                            Student Full Name <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="student_name"
                            name="student_name"
                            required
                            value="{{ old('student_name', session('project_data.student_name')) }}"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="academic_level" class="block text-sm font-medium text-theme-muted mb-2">
                            Academic Level <span class="text-brand-accent">*</span>
                        </label>
                        <select
                            id="academic_level"
                            name="academic_level"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                            <option value="" disabled {{ old('academic_level', session('project_data.academic_level')) ? '' : 'selected' }}>
                                Select academic level
                            </option>
                            <option value="diploma" {{ old('academic_level', session('project_data.academic_level')) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="bachelor" {{ old('academic_level', session('project_data.academic_level')) == 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                            <option value="master" {{ old('academic_level', session('project_data.academic_level')) == 'master' ? 'selected' : '' }}>Master</option>
                            <option value="phd" {{ old('academic_level', session('project_data.academic_level')) == 'phd' ? 'selected' : '' }}>PhD</option>
                            <option value="independent_research" {{ old('academic_level', session('project_data.academic_level')) == 'independent_research' ? 'selected' : '' }}>Independent Research</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                <h4 class="text-2xl font-semibold text-brand-accent mb-4">Supervisor Information</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="supervisor_name" class="block text-sm font-medium text-theme-muted mb-2">
                            Supervisor Name <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="supervisor_name"
                            name="supervisor_name"
                            required
                            value="{{ old('supervisor_name', session('project_data.supervisor_name')) }}"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="supervisor_title" class="block text-sm font-medium text-theme-muted mb-2">
                            Supervisor Title / Position <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="supervisor_title"
                            name="supervisor_title"
                            required
                            value="{{ old('supervisor_title', session('project_data.supervisor_title')) }}"
                            placeholder="e.g., الدكتور / المهندس / الأستاذ المشارك"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>
                </div>
            </div>

            <div class="border border-theme-border p-6 rounded-lg bg-theme-surface-2">
                <h4 class="text-2xl font-semibold text-brand-accent mb-4">Institution Information</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="university_name" class="block text-sm font-medium text-theme-muted mb-2">
                            University / Institution <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="university_name"
                            name="university_name"
                            required
                            value="{{ old('university_name', session('project_data.university_name')) }}"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="college_name" class="block text-sm font-medium text-theme-muted mb-2">
                            College / Faculty <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="college_name"
                            name="college_name"
                            required
                            value="{{ old('college_name', session('project_data.college_name')) }}"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-theme-muted mb-2">
                            Department / Major <span class="text-brand-accent">*</span>
                        </label>
                        <input
                            type="text"
                            id="department"
                            name="department"
                            required
                            value="{{ old('department', session('project_data.department')) }}"
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                    </div>

                    <div>
                        <label for="governorate" class="block text-sm font-medium text-theme-muted mb-2">
                            Governorate <span class="text-brand-accent">*</span>
                        </label>
                        <select
                            id="governorate"
                            name="governorate"
                            required
                            class="w-full p-3 rounded-lg border border-theme-border bg-theme-surface text-theme-text focus:ring-0 focus:border-brand-accent"
                        >
                            <option value="" disabled {{ old('governorate', session('project_data.governorate')) ? '' : 'selected' }}>
                                Select governorate
                            </option>
                            <option value="sanaa" {{ old('governorate', session('project_data.governorate')) == 'sanaa' ? 'selected' : '' }}>Sana'a</option>
                            <option value="aden" {{ old('governorate', session('project_data.governorate')) == 'aden' ? 'selected' : '' }}>Aden</option>
                            <option value="taiz" {{ old('governorate', session('project_data.governorate')) == 'taiz' ? 'selected' : '' }}>Taiz</option>
                            <option value="ibb" {{ old('governorate', session('project_data.governorate')) == 'ibb' ? 'selected' : '' }}>Ibb</option>
                            <option value="hodeidah" {{ old('governorate', session('project_data.governorate')) == 'hodeidah' ? 'selected' : '' }}>Al Hudaydah</option>
                            <option value="hadramout" {{ old('governorate', session('project_data.governorate')) == 'hadramout' ? 'selected' : '' }}>Hadramout</option>
                            <option value="dhamar" {{ old('governorate', session('project_data.governorate')) == 'dhamar' ? 'selected' : '' }}>Dhamar</option>
                            <option value="marib" {{ old('governorate', session('project_data.governorate')) == 'marib' ? 'selected' : '' }}>Ma'rib</option>
                            <option value="amran" {{ old('governorate', session('project_data.governorate')) == 'amran' ? 'selected' : '' }}>Amran</option>
                            <option value="hajjah" {{ old('governorate', session('project_data.governorate')) == 'hajjah' ? 'selected' : '' }}>Hajjah</option>
                            <option value="lahij" {{ old('governorate', session('project_data.governorate')) == 'lahij' ? 'selected' : '' }}>Lahij</option>
                            <option value="shabwah" {{ old('governorate', session('project_data.governorate')) == 'shabwah' ? 'selected' : '' }}>Shabwah</option>
                            <option value="abyan" {{ old('governorate', session('project_data.governorate')) == 'abyan' ? 'selected' : '' }}>Abyan</option>
                            <option value="saada" {{ old('governorate', session('project_data.governorate')) == 'saada' ? 'selected' : '' }}>Saada</option>
                            <option value="aljawf" {{ old('governorate', session('project_data.governorate')) == 'aljawf' ? 'selected' : '' }}>Al Jawf</option>
                            <option value="almahwit" {{ old('governorate', session('project_data.governorate')) == 'almahwit' ? 'selected' : '' }}>Al Mahwit</option>
                            <option value="raymah" {{ old('governorate', session('project_data.governorate')) == 'raymah' ? 'selected' : '' }}>Raymah</option>
                            <option value="albayda" {{ old('governorate', session('project_data.governorate')) == 'albayda' ? 'selected' : '' }}>Al Bayda</option>
                            <option value="aldhale" {{ old('governorate', session('project_data.governorate')) == 'aldhale' ? 'selected' : '' }}>Al Dhale'e</option>
                            <option value="almahrah" {{ old('governorate', session('project_data.governorate')) == 'almahrah' ? 'selected' : '' }}>Al Mahrah</option>
                            <option value="socotra" {{ old('governorate', session('project_data.governorate')) == 'socotra' ? 'selected' : '' }}>Socotra</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <a
                    href="{{ route('project.submit.step1') }}"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold border border-brand-accent text-theme-text hover:bg-brand-accent hover:text-white transition duration-300"
                >
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg px-8 py-3 text-lg font-semibold bg-brand-accent text-white hover:bg-brand-accent-strong transition duration-300 shadow-brand-soft"
                >
                    Save & Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection