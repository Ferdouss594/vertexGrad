@extends('layouts.app')

@section('title', 'Add New Investor')

@section('content')
<style>
    .investor-create-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
        margin-bottom: 24px;
    }

    .investor-create-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .investor-create-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .investor-create-page .content-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .investor-create-page .content-card-body {
        padding: 24px;
    }
</style>

<div class="pd-ltr-20 xs-pd-20-10 investor-create-page">
    <div class="min-height-200px">

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 14px;">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-header-card">
            <h3>Add New Investor</h3>
            <p>Create a complete investor account with profile information, source, investment type, and budget details.</p>
        </div>

        <div class="content-card">
            <div class="content-card-body">
                <form action="{{ route('admin.investors.store') }}" method="POST">
                    @csrf
                    @include('investors._form')
                </form>
            </div>
        </div>

    </div>
</div>
@endsection