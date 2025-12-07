@extends('layouts.app')

@section('title', 'Edit Investor')

@section('content')

<div class="page-header">
    <h4>Edit Investor</h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('investors.update', $investor->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('investors._form')
        </form>
    </div>
</div>

@endsection
