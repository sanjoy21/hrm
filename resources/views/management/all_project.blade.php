@extends('management.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">Home</a></li>
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
                <div class="card-header">
                    <form>
                        <div class="form-group col-md-4">
                            <label>Employee</label>
                            <select class="form-control select2" style="width: 100%;" name="employee">
                                <option selected disabled>Select Employee</option>
                                @foreach ($employee as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ $emp->id == request('employee') ? 'selected' : null }}>
                                        {{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @error('employee')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success">Filter</button>
                            <a href="{{ route('management.project_all') }}" class="btn btn-secondary ml-2">Reset</a>
                        </div>

                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Project Name</th>
                                <th>Employee</th>
                                <th>Project Progress</th>
                                <th class="text-center">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $project->project_name }} <br>
                                        <small>Assigned on: {{ \Carbon\Carbon::parse($project->assign_date)->format('d-m-Y') }}</small>
                                    </td>
                                    <td>

                                        @foreach ($employee as $emp)
                                            @if ($project->employee == $emp->id)
                                                @if ($emp->image && $emp->status == 'active')
                                                    <img class="img-circle"
                                                        style="border: 3px solid #00ff00; height:40px; width:40px;"
                                                        src="{{ asset('storage/' . $emp->image) }}" alt="Profile Picture">
                                                    {{ $emp->name }}
                                                @elseif ($emp->image && $emp->status == 'inactive')
                                                    <img class="img-circle"
                                                        style="border: 3px solid #ff0000; height:40px; width:40px;"
                                                        src="{{ asset('storage/' . $emp->image) }}" alt="Profile Picture">
                                                    {{ $emp->name }}
                                                @elseif (!$emp->image && $emp->status == 'inactive')
                                                    <img class="img-circle"
                                                        style="border: 3px solid #ff0000; height:40px; width:40px;"
                                                        src="{{ asset('dist/img/user.jpg') }}" alt="Profile Picture">
                                                    {{ $emp->name }}
                                                @else
                                                    <img class="img-circle"
                                                        style="border: 3px solid #00ff00; height:40px; width:40px;"
                                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                                    {{ $emp->name }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
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
                                    <td class="project-state"><span
                                            class=" {{ $project->status == 'Assigned' ? 'badge badge-danger' : ($project->status == 'Pending'? 'badge bg-warning' : ($project->status == 'Ongoing'? 'badge bg-primary' : 'badge badge-success')) }}">{{ $project->status }}</span></td>

                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('management.project', $project->id) }}" class="btn btn-success"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('management.project_edit', $project->id) }}" class="btn btn-info"><i
                                                    class="fas fa-edit"></i></a>
                                            <a href="{{ route('management.project_delete', $project->id) }}"
                                                onclick="return confirm('Are you sure want to delete?');"
                                                class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
