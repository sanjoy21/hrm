@extends('employee.index')

@section('title')
    All Project
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Project</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Project</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('error') }}
                    </div>
                @endif

                <div class="card-body">
                    <table id="example1" class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Project Name</th>
                                <th>Deadline</th>
                                <th>Project Progress</th>
                                <th class="text-center">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                @php
                                    // Get unread comments count for this project (from admin)
                                    $unreadCommentsCount = \App\Models\ProjectComment::where('project_id', $project->id)
                                        ->where('user_role', 'admin')
                                        ->where('is_read', false)
                                        ->count();

                                    // Get total comments count for this project
                                    $totalCommentsCount = \App\Models\ProjectComment::where('project_id', $project->id)->count();
                                @endphp

                                <tr class="{{ $unreadCommentsCount > 0 ? 'table-warning' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $project->project_name }} <br>
                                        <small>Assigned on:
                                            {{ \Carbon\Carbon::parse($project->assign_date)->format('d-m-Y') }}</small>
                                        @if($unreadCommentsCount > 0)
                                            <br>
                                            <small class="text-danger">
                                                <i class="fas fa-comment-dots"></i> {{ $unreadCommentsCount == 1 ? '1 new message' : $unreadCommentsCount . ' new messages' }} from Admin!
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d-m-Y') }} </td>

                                    <td class="project_progress">
                                        <div class="progress progress-sm">
                                            @if (\Carbon\Carbon::parse($project->submission_date)->lte(\Carbon\Carbon::parse($project->deadline)))
                                                <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                                    aria-valuemin="0" aria-valuemax="100" aria-valuenow="02"
                                                    style="width: {{ $project->progress }}%">
                                                </div>
                                            @else
                                                <div class="progress-bar bg-danger progress-bar-striped" role="progressbar"
                                                    aria-valuemin="0" aria-valuemax="100" aria-valuenow="02"
                                                    style="width: {{ $project->progress }}%">
                                                </div>
                                            @endif
                                        </div>
                                        <small>
                                            @if (\Carbon\Carbon::parse($project->submission_date)->lte(\Carbon\Carbon::parse($project->deadline)) && $project->submission_date != null)
                                                {{ $project->progress }}% Complete | On time Delivery
                                            @elseif ($project->submission_date == null)
                                                {{ $project->progress }}% Complete
                                            @else
                                                {{ $project->progress }}% Complete | Late Delivery
                                            @endif
                                        </small>
                                    </td>

                                    <td class="project-state text-center">
                                        <span class="{{ $project->status == 'Assigned' ? 'badge badge-danger' : ($project->status == 'Pending' ? 'badge bg-warning' : ($project->status == 'Ongoing' ? 'badge bg-primary' : 'badge badge-success')) }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>

                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('employee.project', $project->id) }}"
                                                class="btn btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                     </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
