@extends('admin.index')

@section('title')
    Add Salary Structure
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Salary Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Salary Structure</li>
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
                                <h3 class="card-title">Salary Structure Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('salary_structure_store') }}" method="post">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group col-md-4">
                                        <label>Employee</label>
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
                                        <label>Basic</label>
                                        <input type="number" name="basic" id="basic" class="form-control calculate-total" placeholder="Enter basic salary" required>
                                        @error('basic')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>House Rent</label>
                                        <input type="number" name="house_rent" id="house_rent" class="form-control calculate-total" placeholder="Enter house rent" required>
                                        @error('house_rent')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Convenience</label>
                                        <input type="number" name="convenience" id="convenience" class="form-control calculate-total" placeholder="Enter convenience allowance" required>
                                        @error('convenience')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Medical</label>
                                        <input type="number" name="medical" id="medical" class="form-control calculate-total" placeholder="Enter medical allowance" required>
                                        @error('medical')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Total</label>
                                        <input type="number" name="total" id="total" class="form-control" readonly style="background-color: #f8f9fa; font-weight: bold;">
                                        @error('total')
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
    // Simple test to see if script is running
    console.log("Salary calculation script loaded!");

    // Get the input elements
    const salaryInputs = document.querySelectorAll('.calculate-total');
    const totalInput = document.getElementById('total');

    // Function to calculate total
    function updateTotal() {
        console.log("updateTotal called");

        let total = 0;

        // Loop through all salary inputs
        salaryInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
            console.log(`${input.id}: ${value}`);
        });

        console.log(`Total: ${total}`);
        totalInput.value = total;
    }

    // Add event listeners to all salary inputs
    salaryInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    // Initial calculation
    updateTotal();
</script>
@endsection
