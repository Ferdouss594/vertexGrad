@extends('layouts.app')

@section('content')
<div class="container" dir="rtl">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>📊 نتائج فحص المشروع: {{ $project->name }}</h3>
                </div>
                <div class="card-body">
                    
                    @if($scanLink)
                        <div class="alert alert-info">
                            <p>هذا المشروع مرتبط مع مشروع رقم <strong>{{ $scanLink->scanner_project_id }}</strong> في منصة الفحص</p>
                            
                            <a href="http://localhost/phpmyadmin/index.php?route=/sql&db=vertexgrad_scanner&table=scan_results&sql_query=SELECT%20*%20FROM%20`scan_results`%20WHERE%20`project_id`%20%3D%20{{ $scanLink->scanner_project_id }}" 
                               class="btn btn-primary" target="_blank">
                                عرض نتائج الفحص في phpMyAdmin
                            </a>
                            
                            <a href="http://localhost/phpmyadmin/index.php?route=/database/structure&db=vertexgrad_scanner" 
                               class="btn btn-info" target="_blank">
                                فتح منصة الفحص كاملة
                            </a>
                        </div>
                        
                        <!-- هنا هنعرض نتائج الفحص مباشرة لو حبيتي -->
                        @php
                            // هنحاول نجيب النتائج من قاعدة البيانات مباشرة
                            try {
                                $scanResults = DB::connection('scanner')
                                    ->table('scan_results')
                                    ->where('project_id', $scanLink->scanner_project_id)
                                    ->get();
                            } catch (\Exception $e) {
                                $scanResults = collect([]);
                            }
                        @endphp
                        
                        @if(count($scanResults) > 0)
                            <h4>نتائج الفحص:</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>النتيجة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scanResults as $result)
                                    <tr>
                                        <td>{{ $result->id }}</td>
                                        <td>{{ json_encode($result) }}</td>
                                        <td>{{ $result->created_at ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>لا توجد نتائج فحص بعد</p>
                        @endif
                        
                    @else
                        <div class="alert alert-warning">
                            هذا المشروع غير مرتبط بأي مشروع في منصة الفحص
                            
                            <a href="{{ url('/admin/link-projects') }}" class="btn btn-success">
                                ربط المشروع الآن
                            </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection