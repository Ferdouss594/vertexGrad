@extends('layouts.app')

@section('title','Projects')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">

        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h4>All Projects</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">
                        + Add Project
                    </a>
                </div>
            </div>
        </div>

        <!-- CHARTS SECTION -->
        <div class="row clearfix progress-box">

            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial1" value="80"
                            data-width="120" data-height="120" data-linecap="round"
                            data-thickness="0.12" data-bgColor="#fff"
                            data-fgColor="#1b00ff" data-angleOffset="180" readonly />
                        <h5 class="text-blue padding-top-10 h5">My Earnings</h5>
                        <span class="d-block">80% Average</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial2" value="70"
                            data-width="120" data-height="120" data-linecap="round"
                            data-thickness="0.12" data-bgColor="#fff"
                            data-fgColor="#00e091" data-angleOffset="180" readonly />
                        <h5 class="text-light-green padding-top-10 h5">Business Captured</h5>
                        <span class="d-block">75% Average</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial3" value="90"
                            data-width="120" data-height="120" data-linecap="round"
                            data-thickness="0.12" data-bgColor="#fff"
                            data-fgColor="#f56767" data-angleOffset="180" readonly />
                        <h5 class="text-light-orange padding-top-10 h5">Projects Speed</h5>
                        <span class="d-block">90% Average</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial4" value="65"
                            data-width="120" data-height="120" data-linecap="round"
                            data-thickness="0.12" data-bgColor="#fff"
                            data-fgColor="#a683eb" data-angleOffset="180" readonly />
                        <h5 class="text-light-purple padding-top-10 h5">Pending Orders</h5>
                        <span class="d-block">65% Average</span>
                    </div>
                </div>
            </div>

        </div>
        <!-- END CHARTS -->

        <!-- PROJECTS TABLE -->
        <div class="card-box bg-white p-3 mt-4">

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Student</th>
                        <th>Supervisor</th>
                        <th>Manager</th>
                        <th>Investor</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Start</th>
                        <th>End</th>
                        <th width="120px">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <a href="{{ route('projects.show', $project->id) }}">
                                    {{ $project->name }}
                                </a>
                            </td>

                            <td>{{ $project->student->name ?? '—' }}</td>
                            <td>{{ $project->supervisor->name ?? '—' }}</td>
                            <td>{{ $project->manager->name ?? '—' }}</td>
                            <td>{{ $project->investor->name ?? '—' }}</td>

                            <td>
                                <span class="badge 
                                    @if($project->status=='Pending') badge-warning 
                                    @elseif($project->status=='Active') badge-primary
                                    @else badge-success @endif">
                                    {{ $project->status }}
                                </span>
                            </td>

                            <td>{{ $project->progress ?? 0 }}%</td>
                            <td>{{ $project->start_date ?? '—' }}</td>
                            <td>{{ $project->end_date ?? '—' }}</td>

                            <td>
                                <a href="{{ route('projects.show',$project->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
        <!-- END TABLE -->

    </div>
</div>

@endsection
