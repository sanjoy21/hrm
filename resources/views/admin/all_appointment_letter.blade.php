@extends('admin.index')

@section('title')
    All Appointment Letter
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Appointment Letter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Appointment Letter</li>
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
                            {{-- <div class="card-header">
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
                                        <a href="{{ route('application_all') }}" class="btn btn-secondary ml-2">Reset</a>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header --> --}}
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($letters as $letter)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $letter->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($letter->date)->format('d-m-Y') }}</td>

                                                <td class="text-right py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('appointment_letter', $letter->id) }}"
                                                            class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                        {{-- <a href="{{ route('warning_edit', $warning->id) }}" class="btn btn-info"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('warning_delete', $warning->id) }}"
                                                            onclick="return confirm('Are you sure want to delete?');"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}
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
