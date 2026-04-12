@extends('admin.index')

@section('title')
    All Salary Sheet
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Salary Sheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Salary Sheet</li>
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
                                <form>
                                    <div class="form-group col-md-4">
                                        <label>Month</label>
                                        <select class="form-control select2" style="width: 100%;" name="month">
                                            <option selected disabled>Select Month</option>
                                            <option value="January" {{ $selected_month == "January" ? 'selected' : '' }}>January</option>
                                            <option value="February" {{ $selected_month == "February" ? 'selected' : '' }}>February</option>
                                            <option value="March" {{ $selected_month == "March" ? 'selected' : '' }}>March</option>
                                            <option value="April" {{ $selected_month == "April" ? 'selected' : '' }}>April</option>
                                            <option value="May" {{ $selected_month == "May" ? 'selected' : '' }}>May</option>
                                            <option value="June" {{ $selected_month == "June" ? 'selected' : '' }}>June</option>
                                            <option value="July" {{ $selected_month == "July" ? 'selected' : '' }}>July</option>
                                            <option value="August" {{ $selected_month == "August" ? 'selected' : '' }}>August</option>
                                            <option value="September" {{ $selected_month == "September" ? 'selected' : '' }}>September</option>
                                            <option value="October" {{ $selected_month == "October" ? 'selected' : '' }}>October</option>
                                            <option value="November" {{ $selected_month == "November" ? 'selected' : '' }}>November</option>
                                            <option value="December" {{ $selected_month == "December" ? 'selected' : '' }}>December</option>

                                        </select>
                                        @error('month')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
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

                                    <div class="form-group col-md-4">
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


                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Filter</button>
                                        <a href="{{  route('salary_sheet_view') }}" class="btn btn-secondary ml-2">Reset</a>
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
                                            <th>Salary</th>
                                            <th>Bonus</th>
                                            <th>Performance Bonus</th>
                                            <th>Other Add</th>
                                            <th>Advance</th>
                                            <th>AIT</th>
                                            <th>Revenue Stamp</th>
                                            <th>Late Attendance</th>
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
                                                <td>{{ $data->month }}</td>
                                                <td>{{ $data->year }}</td>
                                                <td>
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $data->employee_id)
                                                            {{ $employee->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $data->salary }}</td>
                                                <td>{{ $data->bonus }}</td>
                                                <td>{{ $data->performance_bonus }}</td>
                                                <td>{{ $data->other_add }}</td>
                                                <td>{{ $data->advance }}</td>
                                                <td>{{ $data->ait }}</td>
                                                <td>{{ $data->revenue_stamp }}</td>
                                                <td>{{ $data->late_attendance }}</td>
                                                <td>{{ $data->other }}</td>
                                                <td>{{ $data->total_paid }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->date_of_payment)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $data->comment }}</td>


                                                {{-- <td class="text-right py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('salary_sheet', $salary->id) }}"
                                                            class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('edit_salary_structure', $salary->id) }}" class="btn btn-info"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('salary_structure_delete', $salary->id) }}"
                                                            onclick="return confirm('Are you sure want to delete?');"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </td> --}}
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
