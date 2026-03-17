@extends('layouts.app')

@section('title', 'Scanner Review')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 14px;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <style>
            .scanner-review-page .page-header-card {
                background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
                border-radius: 20px;
                padding: 28px 30px;
                color: #fff;
                box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
                margin-bottom: 24px;
            }

            .scanner-review-page .page-header-card h3 {
                margin: 0;
                font-weight: 700;
                color: #fff;
            }

            .scanner-review-page .page-header-card p {
                margin: 8px 0 0;
                opacity: 0.92;
            }

            .scanner-review-page .review-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
                border: 1px solid #edf2f7;
                overflow: hidden;
            }

            .scanner-review-page .review-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid #eef2f7;
                background: #f8fafc;
            }

            .scanner-review-page .review-card-header h5 {
                margin: 0;
                font-weight: 700;
                color: #0f172a;
            }

            .scanner-review-page .review-card-body {
                padding: 24px;
            }

            .scanner-review-page .info-box {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 18px;
                height: 100%;
            }

            .scanner-review-page .info-label {
                font-size: 12px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: .4px;
                margin-bottom: 8px;
            }

            .scanner-review-page .info-value {
                font-size: 18px;
                font-weight: 700;
                color: #0f172a;
                word-break: break-word;
            }

            .scanner-review-page .note-box {
                background: #eff6ff;
                border: 1px solid #bfdbfe;
                color: #1e40af;
                border-radius: 16px;
                padding: 18px;
                line-height: 1.8;
            }

            .scanner-review-page .btn-start {
                background: linear-gradient(135deg, #16a34a, #22c55e);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 700;
                box-shadow: 0 10px 20px rgba(34, 197, 94, 0.18);
            }

            .scanner-review-page .btn-start:hover {
                color: #fff;
                opacity: 0.95;
            }

            .scanner-review-page .btn-back {
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 700;
            }
        </style>

        <div class="scanner-review-page">

            <div class="page-header-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                    <div>
                        <h3>Review & Start Technical Scan</h3>
                        <p>Confirm the core project details before sending the project to the scanner platform.</p>
                    </div>

                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-light btn-back">
                        <i class="fa fa-arrow-left mr-1"></i> Back to Edit
                    </a>
                </div>
            </div>

            <div class="review-card mb-4">
                <div class="review-card-header">
                    <h5>Project Scan Information</h5>
                </div>

                <div class="review-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Project Name</div>
                                <div class="info-value">{{ $project->name ?? '—' }}</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Student Name</div>
                                <div class="info-value">{{ $project->student->name ?? '—' }}</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <div class="info-label">Student Email</div>
                                <div class="info-value">{{ $project->student->email ?? '—' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="note-box mt-3">
                        By clicking <strong>Start Technical Scan</strong>, the system will create a scanner request for this project and open the scanner platform directly so the scan process can continue there.
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.projects.startScan', $project) }}" method="POST">
                @csrf

                <div class="d-flex flex-wrap" style="gap: 12px;">
                    <button type="submit" class="btn btn-start">
                        <i class="fa fa-shield-alt mr-1"></i> Start Technical Scan
                    </button>

                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-secondary btn-back">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection