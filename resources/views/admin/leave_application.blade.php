@extends('admin.index')

@section('title')
    Apply for Leave
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Apply for Leave</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Apply for Leave</li>
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
                                <h3 class="card-title">Leave Application Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('leave_application_store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="employee_id" value="{{ Auth::guard('admin')->user()->id }}">

                                <div class="form-group col-md-4">
                                        <label>Leave type</label>
                                        <select name="leave_type" class="form-control">
                                            <option selected disabled>Select Leave type</option>
                                            @foreach ($leave_types as $leave_type)
                                                <option value="{{ $leave_type->id }}">{{ $leave_type->leave_name }}</option>
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
                                    <label>From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control">
                                    @error('from_date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                    @error('to_date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                    <input type="hidden" name="total_day" id="total_day" class="form-control">

                                <div class="form-group col-md-12">
                                    <label>Application</label>
                                    <textarea name="application" id="compose-textarea" class="form-control" style="height: 300px">
                                        <p>{{ date('jS F, Y') }}</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for leave in advance.</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am {{ Auth::guard('admin')->user()->name }}, an employee of your company, RK Software (Bangladesh) Limited. My designation is {{ Auth::guard('admin')->user()->designation }}. I have an occasion in my house on 26/02/2026. That's why I need 1 day leave.</p><p>I, therefore, pray and hope that you will consider my case and approve my leave.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>{{ Auth::guard('admin')->user()->name }}<br>{{ Auth::guard('admin')->user()->designation }}<br>Mobile: {{ Auth::guard('admin')->user()->mobile }}</p><br>
                                    </textarea>
                                    @error('application')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Apply</button>
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
        $(function() {
            //Add text editor
            $('#compose-textarea').summernote()
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fromDateInput = document.getElementById("from_date");
            const toDateInput = document.getElementById("to_date");
            const totalDayInput = document.getElementById("total_day");

            function calculateDays() {
                const fromDate = new Date(fromDateInput.value);
                const toDate = new Date(toDateInput.value);

                if (fromDate && toDate && !isNaN(fromDate) && !isNaN(toDate)) {
                    const diffTime = toDate.getTime() - fromDate.getTime();
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both days

                    totalDayInput.value = diffDays > 0 ? diffDays : 0;
                } else {
                    totalDayInput.value = "";
                }
            }

            fromDateInput.addEventListener("change", calculateDays);
            toDateInput.addEventListener("change", calculateDays);
        });
    </script>
@endsection
