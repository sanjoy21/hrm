@extends('admin.index')

@section('title')
    Edit Project
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Project</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Project</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

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
                                <h3 class="card-title">Project Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('project_update',$project->id) }}" method="post">
                                @csrf
                                <div class="card-body">


                                    <div class="form-group col-md-4">
                                        <label>Assign To</label>
                                        <select name="employee" class="form-control">
                                            <option selected disabled>Select Employee</option>
                                            @foreach ($employees->sortBy('name') as $employee)
                                                <option value="{{ $employee->id }}" {{ $employee->id == $project->employee ? 'selected' : null }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Employer</label>
                                        <select name="employer" class="form-control">
                                            <option selected disabled>Select Employer</option>
                                            @foreach ($employers->sortBy('name') as $employer)
                                                <option value="{{ $employer->id }}" {{ $employer->id == $project->employer ? 'selected' : null }}>{{ $employer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employer')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Assign Date</label>
                                        <input type="date" name="assign_date" class="form-control" value="{{ $project->assign_date }}">
                                        @error('assign_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Deadline</label>
                                        <input type="date" name="deadline" class="form-control" value="{{ $project->deadline }}">
                                        @error('deadline')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="Assigned" {{ $project->status == "Assigned" ? 'selected' : null }}>Assigned</option>
                                            <option value="Pending" {{ $project->status == "Pending" ? 'selected' : null }}>Pending</option>
                                            <option value="Ongoing" {{ $project->status == "Ongoing" ? 'selected' : null }}>Ongoing</option>
                                            <option value="Completed" {{ $project->status == "Completed" ? 'selected' : null }}>Completed</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Project Name</label>
                                        <input type="text" name="project_name" class="form-control" value="{{ $project->project_name }}">
                                        @error('project_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Project Details</label>
                                        <textarea name="details" id="compose-textarea" class="form-control" style="height: 300px">{{ $project->project_details }}</textarea>
                                        @error('details')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->



                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })
</script>
@endsection
