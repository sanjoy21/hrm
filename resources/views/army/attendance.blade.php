@extends('army.index')

@section('title')
    Employee Attendance
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Attendance</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('army.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Employee Attendance</li>
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

                            <div class="card-header bg-light">
                                <h3 class="card-title">Filter Attendance</h3>
                            </div>

                            <div class="card-body">
                                <form method="GET" action="{{ route('army.attendance') }}">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Month</label>
                                            <select class="form-control select2" name="month">
                                                <option value="">All Months</option>
                                                @php
                                                    $months = [
                                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                                    ];
                                                @endphp

                                                @foreach ($months as $num => $name)
                                                    <option value="{{ $num }}" {{ $selected_month == $num ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Year</label>
                                            <select class="form-control select2" name="year">
                                                <option value="">All Years</option>
                                                @foreach ($distinct_years as $year)
                                                    <option value="{{ $year }}" {{ $selected_year == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Employee</label>
                                            <select class="form-control select2" name="employee">
                                                <option value="">All Employees</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ $selected_employee_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                                <a href="{{ route('army.attendance') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                            <div class="card">

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Check In</th>
                                            <th>Check In Address</th>
                                            <th>Check Out</th>
                                            <th>Check Out Address</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all as $attend)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attend->date)->format('d-m-Y') }}</td>
                                                <td>
                                                @foreach ($employees as $employee)
                                                @if ($employee->id == $attend->employee_id)
                                                   {{ $employee->name }}
                                                @endif

                                                @endforeach
                                                </td>

                                                <td>{{ $attend->check_in }}</td>
                                                <td>{{ $attend->check_in_address ? $attend->check_in_address : 'N/A' }}</td>
                                                <td>{{ $attend->check_out ? $attend->check_out : 'Not Checked Out' }}</td>
                                                <td>{{ $attend->check_out_address ? $attend->check_out_address : 'N/A' }}</td>

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
