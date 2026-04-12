@extends('admin.index')

@section('title')
    Edit Salary Structure
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Salary Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Salary Structure</li>
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
                                <h3 class="card-title">Edit Salary Structure</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('salary_structure_update',$salary->id) }}" method="post">
                                @csrf
                                <div class="card-body">


                                    <div class="form-group col-md-4">
                                        <label>Employee</label>
                                        <select name="employee" class="form-control" disabled>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ $employee->id == $salary->employee_id ? 'selected' : null }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="form-group col-md-4">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option selected disabled>Select Type</option>
                                            <option value="Promotion">Promotion</option>
                                            <option value="Demotion">Demotion</option>

                                        </select>
                                        @error('type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group col-md-4">
                                        <label>Basic</label>
                                        <input type="number" name="basic" id="basic" class="form-control calculate-total" value="{{ $salary->basic }}">
                                        @error('basic')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>House Rent</label>
                                        <input type="number" name="house_rent" id="house_rent" class="form-control calculate-total"value="{{ $salary->house_rent }}">
                                        @error('house_rent')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Convenience</label>
                                        <input type="number" name="convenience" id="convenience" class="form-control calculate-total" value="{{ $salary->convenience }}">
                                        @error('convenience')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Medical</label>
                                        <input type="number" name="medical" id="medical" class="form-control calculate-total" value="{{ $salary->medical }}">
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
                                    <button type="submit" class="btn btn-success">Update</button>
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
