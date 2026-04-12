@extends('employee.index')

@section('title')
    Hourly Work Update
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Hourly Work Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Hourly Work Update</li>
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
                                <h3 class="card-title">Hourly Work Update Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('employee.hourly_work_update_store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}">

                                <div class="form-group col-md-4">
                                        <label>Time</label>
                                        <select name="time" class="form-control">
                                            <option selected disabled>Select Time</option>
                                            <option value="9_10">9-10</option>
                                            <option value="10_11">10-11</option>
                                            <option value="11_12">11-12</option>
                                            <option value="12_1">12-1</option>
                                            <option value="1_2">1-2</option>
                                            <option value="2_3">2-3</option>
                                            <option value="3_4">3-4</option>
                                            <option value="4_5">4-5</option>

                                        </select>
                                        @error('time')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                <div class="form-group col-md-12">
                                    <label>Work List</label>
                                    <textarea name="work_list" id="compose-textarea" class="form-control" style="height: 300px"></textarea>
                                    @error('work_list')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Submit</button>
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
