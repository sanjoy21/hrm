@extends('admin.index')

@section('title')
    Manual Leave Approval
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manual Leave Approval</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Manual Leave Approval</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

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
                                <form action="{{ route('manual_leave_approval_store')}}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <label>Employee</label>
                                        <select class="form-control select2" style="width: 100%;" name="employee">
                                            <option selected disabled>Select Employee</option>
                                            @foreach ($employees->sortBy('name') as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ $emp->id == request('employee') ? 'selected' : null }}>
                                                    {{ $emp->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Leave Type</label>
                                        <select class="form-control select2" style="width: 100%;" name="leave_type">
                                            <option selected disabled>Select Leave Type</option>
                                            @foreach ($leave_types as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->leave_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('leave_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Day type</label>
                                        <select name="day_type" class="form-control">
                                            <option selected disabled>Select Day type</option>
                                            <option value="Full Day">Full Day Leave</option>
                                            <option value="Half Day">Half Day Leave</option>
                                        </select>
                                        @error('day_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control">
                                    @error('date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Comment</label>
                                    <textarea name="comment" class="form-control" rows="4"></textarea>
                                    @error('comment')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <input type="hidden" name="approved_by"
                                            value="{{ Auth::guard('admin')->user()->id }}">


                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header -->

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
