@extends('admin.index')

@section('title')
    Add NOC
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add NOC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add NOC</li>
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
                                <h3 class="card-title">NOC Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('noc_add_store') }}" method="post">
                                @csrf
                                <div class="card-body">


                                    <div class="form-group col-md-4">
                                        <label>Employee Name</label>
                                        <select name="employee" class="form-control">
                                            <option selected disabled>Select Employee</option>
                                            @foreach ($employees->sortBy('name') as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('employee')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Salutation</label>
                                        <select name="salutation" class="form-control">
                                            <option selected disabled>Select Salutation</option>
                                                <option value="He">He</option>
                                                <option value="She">She</option>
                                        </select>
                                        @error('salutation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>NOC Type</label>
                                        <select name="noc_type" class="form-control" required>
                                            <option selected disabled>Select NOC Type</option>
                                            @foreach ($noc_types->sortBy('noc_name') as $noc)
                                                <option value="{{ $noc->id }}">{{ $noc->noc_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('noc_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control">
                                    </div>

                                    <input type="hidden" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}">

                                    <div class="form-group col-md-4">
                                        <label>Passport (if any)</label>
                                        <input type="text" name="passport" class="form-control">
                                        @error('passport')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control">
                                        @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Reason</label>
                                        <input type="text" name="reason" class="form-control" placeholder="Ex: medical purpose">
                                        @error('reason')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Generate NOC</button>
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
