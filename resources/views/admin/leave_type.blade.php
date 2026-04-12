@extends('admin.index')

@section('title')
    Leave Type
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Leave Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Leave Type</li>
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
                                <form action="{{ route('leave_type_store') }}" method="POST">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Leave Name</label>
                                        <input type="text" name="leave_name" class="form-control"/>
                                        @error('leave_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Leave Name</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leave_types as $leave)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $leave->leave_name }}</td>
                                                <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    {{-- <a href="#" class="btn btn-success"><i class="fas fa-eye"></i></a> --}}
                                                    <a href="{{ route('leave_type_edit', $leave->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('leave_type_delete', $leave->id) }}"
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
