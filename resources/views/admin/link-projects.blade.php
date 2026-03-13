@extends('layouts.app')

@section('content')
<div class="container" dir="rtl">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>🔗 ربط المشاريع مع منصة الفحص</h3>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ url('/admin/link-projects') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label>مشروع المنصة الرئيسية:</label>
                            <select name="main_project_id" class="form-control" required>
                                <option value="">-- اختر المشروع --</option>
                                @foreach($mainProjects as $project)
                                    <option value="{{ $project->project_id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>رقم المشروع في منصة الفحص (vertexgrad_scanner):</label>
                            <input type="number" name="scanner_project_id" class="form-control" 
                                   required placeholder="مثال: 122">
                            <small class="text-muted">رقم المشروع من جدول projects في منصة الفحص</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">ربط المشاريع</button>
                    </form>
                    
                    <hr>
                    
                    <h4>المشاريع المرتبطة</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>المشروع</th>
                                <th>رقم المشروع في الفحص</th>
                                <th>الحالة</th>
                                <th>تاريخ الربط</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($linkedProjects as $link)
                            <tr>
                                <td>{{ $link->project_name }}</td>
                                <td>{{ $link->scanner_project_id }}</td>
                                <td>
                                    @if($link->status == 'pending')
                                        <span class="badge badge-warning">في الانتظار</span>
                                    @elseif($link->status == 'imported')
                                        <span class="badge badge-success">تم الاستيراد</span>
                                    @else
                                        <span class="badge badge-danger">فشل</span>
                                    @endif
                                </td>
                                <td>{{ $link->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection