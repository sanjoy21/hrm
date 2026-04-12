@extends('admin.index')

@section('title')
    Initial Salary Sheet
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Initial Salary Sheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Initial Salary Sheet</li>
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
                                <form method="GET" action="{{ route('initial_salary_sheet') }}">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Month</label>
                                            <select class="form-control select2" style="width: 100%;" name="month">
                                                <option selected disabled>Select Month</option>
                                                <option value="January"
                                                    {{ $selected_month == 'January' ? 'selected' : '' }}>January</option>
                                                <option value="February"
                                                    {{ $selected_month == 'February' ? 'selected' : '' }}>February</option>
                                                <option value="March" {{ $selected_month == 'March' ? 'selected' : '' }}>
                                                    March</option>
                                                <option value="April" {{ $selected_month == 'April' ? 'selected' : '' }}>
                                                    April</option>
                                                <option value="May" {{ $selected_month == 'May' ? 'selected' : '' }}>May
                                                </option>
                                                <option value="June" {{ $selected_month == 'June' ? 'selected' : '' }}>
                                                    June</option>
                                                <option value="July" {{ $selected_month == 'July' ? 'selected' : '' }}>
                                                    July</option>
                                                <option value="August" {{ $selected_month == 'August' ? 'selected' : '' }}>
                                                    August</option>
                                                <option value="September"
                                                    {{ $selected_month == 'September' ? 'selected' : '' }}>September
                                                </option>
                                                <option value="October"
                                                    {{ $selected_month == 'October' ? 'selected' : '' }}>October</option>
                                                <option value="November"
                                                    {{ $selected_month == 'November' ? 'selected' : '' }}>November</option>
                                                <option value="December"
                                                    {{ $selected_month == 'December' ? 'selected' : '' }}>December</option>
                                            </select>
                                            @error('month')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Year</label>
                                            <select class="form-control select2" style="width: 100%;" name="year">
                                                <option selected disabled>Select Year</option>
                                                @foreach ($distinct_years as $year)
                                                    <option value="{{ $year }}"
                                                        {{ $selected_year == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('year')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Employee</label>
                                            <select class="form-control select2" style="width: 100%;" name="employee">
                                                <option selected disabled>Select Employee</option>
                                                @foreach ($employees->sortBy('name') as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $selected_employee_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-success">Filter</button>
                                            <a href="{{ route('initial_salary_sheet') }}"
                                                class="btn btn-secondary ml-2">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Employee Name</th>
                                            <th>Employee ID</th>
                                            <th>Bank Account No</th>
                                            <th>Salary</th>
                                            <th>Bonus</th>
                                            <th>Performance Bonus</th>
                                            <th>Other Add</th>
                                            <th>Advance</th>
                                            <th>AIT</th>
                                            <th>Revenue Stamp</th>
                                            <th>Late Days</th>
                                            <th>Days Deducted</th>
                                            <th>Late Deduction</th>
                                            <th>Other Deduction</th>
                                            <th>Total Paid</th>
                                            <th>Date of Payment</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->display_month }}</td>
                                                <td>{{ $data->display_year }}</td>
                                                <td>
                                                    @php
                                                        $employee = $employees->firstWhere('id', $data->employee_id);
                                                    @endphp
                                                    {{$employee->name }}
                                                </td>
                                                <td>{{ $data->employee_id }}</td>
                                                <td>
                                                    @php
                                                        $employee = $employees->firstWhere('id', $data->employee_id);
                                                    @endphp
                                                    {{$employee->account_no}}
                                                </td>
                                                <td>{{ number_format($data->total, 0) }}</td>
                                                <td>{{ number_format($data->bonus ?? 0) }}</td>
                                                <td>{{ number_format($data->performance_bonus ?? 0) }}</td>
                                                <td>{{ number_format($data->other_add ?? 0) }}</td>
                                                <td><span class="text-danger">{{ number_format($data->advance ?? 0) }}</span></td>
                                                <td><span class="text-danger">{{ number_format($data->ait ?? 0) }}</span></td>
                                                <td><span class="text-danger">10</span></td>
                                                <td>
                                                    @if (isset($data->late_days) && $data->late_days > 0)
                                                        <span class="badge badge-warning">
                                                            {{ $data->late_days }} days
                                                        </span>
                                                    @else
                                                        <span class="text-danger">0</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($data->deduction_days) && $data->deduction_days > 0)
                                                        <span class="badge badge-danger">
                                                            {{ $data->deduction_days }} days
                                                        </span>
                                                    @else
                                                        <span class="text-danger">0</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($data->late_deduction) && $data->late_deduction > 0)
                                                        <span class="text-danger">
                                                            {{ number_format($data->late_deduction, 0) }}
                                                            {{-- Removed decimal places --}}
                                                        </span>
                                                    @else
                                                        <span class="text-danger">0</span>
                                                    @endif
                                                </td>
                                                <td><span class="text-danger">{{ number_format($data->other ?? 0) }}</span></td>
                                                <td>
                                                    <strong class="text-success">
                                                        {{ number_format($data->calculated_total_paid ?? 0) }}
                                                    </strong>
                                                </td>
                                                <td>DD-MM-YYYY</td>
                                                <td></td>
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

{{-- @push('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush --}}
