@extends('admin.index')

@section('title')
    Add Salary Sheet
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Salary Sheet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item" active>Add Salary Sheet</li>
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
                                <h3 class="card-title">Monthly Salary Sheet Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('salary_sheet_store') }}" method="post">
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
                                        <label>Month</label>
                                        <select name="month" class="form-control">
                                            <option selected disabled>Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                        @error('month')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Year</label>
                                        <input type="text" name="year" class="form-control"
                                            placeholder="Ex: {{ date('Y') }}" required>
                                        @error('year')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <hr>

                                    <div class="form-group col-md-12">
                                        <h4 style="color: green;">Addition</h4>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Salary</label>
                                        <input type="number" name="salary" id="salary"
                                            class="form-control addition-field" placeholder="Salary" required>
                                        @error('salary')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Bonus</label>
                                        <input type="number" name="bonus" id="bonus"
                                            class="form-control addition-field" placeholder="Bonus" value="0">
                                        @error('bonus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Performance Bonus</label>
                                        <input type="number" name="performance_bonus" id="performance_bonus"
                                            class="form-control addition-field" placeholder="Performance Bonus"
                                            value="0">
                                        @error('performance_bonus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Other Add</label>
                                        <input type="number" name="other_add" id="other_add"
                                            class="form-control addition-field" placeholder="Other Add" value="0">
                                        @error('other_add')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Total Addition</label>
                                        <input type="number" id="total_addition" class="form-control" readonly
                                            style="background-color: #e8f5e9; font-weight: bold;" value="0">
                                    </div>

                                    <hr>

                                    <div class="form-group col-md-12">
                                        <h4 style="color: red;">Deduction</h4>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Advance</label>
                                        <input type="number" name="advance" id="advance"
                                            class="form-control deduction-field" placeholder="Advance" value="0">
                                        @error('advance')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>AIT</label>
                                        <input type="number" name="ait" id="ait"
                                            class="form-control deduction-field" placeholder="AIT" value="0">
                                        @error('ait')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Revenue Stamp</label>
                                        <input type="number" name="revenue_stamp" id="revenue_stamp"
                                            class="form-control deduction-field" placeholder="Revenue Stamp"
                                            value="0">
                                        @error('revenue_stamp')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Late Attendance</label>
                                        <input type="number" name="late_attendance" id="late_attendance"
                                            class="form-control deduction-field" placeholder="Late Attendance"
                                            value="0">
                                        @error('late_attendance')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Other Deduction</label>
                                        <input type="number" name="other" id="other_deduction"
                                            class="form-control deduction-field" placeholder="Other Deduction"
                                            value="0">
                                        @error('other')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Total Deduction</label>
                                        <input type="number" id="total_deduction" class="form-control" readonly
                                            style="background-color: #ffebee; font-weight: bold;" value="0">
                                    </div>

                                    <hr>

                                    <div class="form-group col-md-4">
                                        <label>Total Paid</label>
                                        <input type="number" name="total_paid" id="total_paid" class="form-control"
                                            readonly style="background-color: #f8f9fa; font-weight: bold; font-size: 18px;"
                                            value="0">
                                        @error('total_paid')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date of Payment</label>
                                        <input type="date" name="date_of_payment" class="form-control">
                                        @error('date_of_payment')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Comment</label>
                                        <textarea name="comment" class="form-control"></textarea>
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

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <!-- <label for="customFile">Custom File</label> -->
                            <form action="{{ route('uploadexcel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-12 col-form-label">Upload Excel File</label>
                                    <div class="col-md-12">
                                        <input type="file" name="excel_file" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                </div>
                            </form>

                            <div class="mb-3">
                                <a href="{{ route('download.sample') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download Sample Format
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Salary Sheet calculation script loaded!");

            // Get all addition fields
            const additionFields = document.querySelectorAll('.addition-field');
            const totalAdditionInput = document.getElementById('total_addition');

            // Get all deduction fields
            const deductionFields = document.querySelectorAll('.deduction-field');
            const totalDeductionInput = document.getElementById('total_deduction');

            // Get total paid field
            const totalPaidInput = document.getElementById('total_paid');

            // Function to calculate sum of an array of inputs
            function calculateSum(fields) {
                let sum = 0;
                fields.forEach(field => {
                    const value = parseFloat(field.value) || 0;
                    sum += value;
                });
                return sum;
            }

            // Function to update all calculations
            function updateCalculations() {
                console.log("Updating calculations...");

                // Calculate total addition
                const totalAddition = calculateSum(additionFields);
                totalAdditionInput.value = totalAddition;
                console.log("Total Addition:", totalAddition);

                // Calculate total deduction
                const totalDeduction = calculateSum(deductionFields);
                totalDeductionInput.value = totalDeduction;
                console.log("Total Deduction:", totalDeduction);

                // Calculate net total (addition - deduction)
                const netTotal = totalAddition - totalDeduction;
                totalPaidInput.value = netTotal;
                console.log("Net Total:", netTotal);

                // Update total paid in the form
                totalPaidInput.value = netTotal;
            }

            // Add event listeners to all addition fields
            additionFields.forEach(field => {
                field.addEventListener('input', updateCalculations);
                field.addEventListener('change', updateCalculations);
                field.addEventListener('keyup', updateCalculations);
            });

            // Add event listeners to all deduction fields
            deductionFields.forEach(field => {
                field.addEventListener('input', updateCalculations);
                field.addEventListener('change', updateCalculations);
                field.addEventListener('keyup', updateCalculations);
            });

            // Initial calculation
            updateCalculations();

            // Auto-fill current year
            // const yearInput = document.querySelector('input[name="year"]');
            // if (!yearInput.value) {
            //     yearInput.value = new Date().getFullYear();
            // }

            // Set today's date as default for date of payment
            // const dateOfPaymentInput = document.querySelector('input[name="date_of_payment"]');
            // if (!dateOfPaymentInput.value) {
            //     const today = new Date();
            //     const formattedDate = today.toISOString().split('T')[0];
            //     dateOfPaymentInput.value = formattedDate;
            // }
        });
    </script>
@endsection
