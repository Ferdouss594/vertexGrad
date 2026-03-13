{{-- resources/views/admin/investment-requests/create.blade.php --}}
@extends('layouts.app')

@section('title', 'إضافة طلب استثمار جديد')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">إضافة طلب استثمار جديد</h4>
        <a href="{{ route('admin.investment-requests.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.investment-requests.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- المستثمر -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المستثمر <span class="text-danger">*</span></label>
                        <select name="investor_id" class="form-select @error('investor_id') is-invalid @enderror" required>
                            <option value="">اختر المستثمر</option>
                            @foreach($investors as $investor)
                                <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>
                                    {{ $investor->user->name ?? '' }} - {{ $investor->company ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('investor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- المشروع -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المشروع <span class="text-danger">*</span></label>
                        <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                            <option value="">اختر المشروع</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- المبلغ -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المبلغ <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount') }}" required>
                        </div>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- نسبة المشاركة -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نسبة المشاركة %</label>
                        <input type="number" step="0.01" min="0" max="100" name="equity_percentage" 
                               class="form-control @error('equity_percentage') is-invalid @enderror" 
                               value="{{ old('equity_percentage') }}">
                        @error('equity_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- رسالة -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">رسالة</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                  rows="4">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- أزرار -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> حفظ
                        </button>
                        <a href="{{ route('admin.investment-requests.index') }}" class="btn btn-secondary">
                            إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection