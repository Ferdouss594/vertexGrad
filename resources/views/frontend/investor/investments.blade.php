@extends('frontend.layouts.app')

@section('content')

<div class="container py-10">

<h2 class="text-3xl font-bold mb-6">My Investments</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Project</th>
<th>Student</th>
<th>Status</th>
<th>Amount</th>
<th>Date</th>
</tr>
</thead>

<tbody>

@foreach($projects as $project)

<tr>

<td>
<a href="{{ route('frontend.projects.show',$project) }}">
{{ $project->name }}
</a>
</td>

<td>
{{ $project->student->name ?? '-' }}
</td>

<td>
{{ ucfirst($project->pivot->status) }}
</td>

<td>
${{ number_format($project->pivot->amount ?? 0) }}
</td>

<td>
{{ $project->pivot->created_at->format('d M Y') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
