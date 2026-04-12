@extends('admin.index')

@section('title')
    Add Employee
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Employee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Employee</li>
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
                                <h3 class="card-title">Employee Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('employee.store') }}" method="post">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group col-md-6">
                                        <label>Office</label>
                                        <select class="form-control select2" style="width: 100%;" name="office" required>
                                            <option selected disabled>Select Office</option>
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('office')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Department</label>
                                        <select class="form-control select2" style="width: 100%;" name="department"
                                            required>
                                            <option selected disabled>Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Role</label>
                                        <select class="form-control select2" style="width: 100%;" name="role" required>
                                            <option selected disabled>Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="management">Management</option>
                                            <option value="employee">Employee</option>
                                        </select>
                                        @error('role')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Full Name"
                                            required>
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Email" required>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1" placeholder="Password" required>
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" required>
                                        @error('dob')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Select Gender</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio1"
                                                name="gender" value="male">
                                            <label for="customRadio1" class="custom-control-label">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio2"
                                                name="gender" value="female">
                                            <label for="customRadio2" class="custom-control-label">Female</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Mobile</label>
                                        <input type="text" name="mobile" class="form-control"
                                            placeholder="Enter Mobile No" required>
                                        @error('mobile')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>NID</label>
                                        <input type="text" name="nid" class="form-control"
                                            placeholder="Enter NID No" required>
                                        @error('nid')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Designation</label>
                                        <input type="text" name="designation" class="form-control"
                                            placeholder="Ex: Software Engineer" required>
                                        @error('designation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Emergency Contact Number</label>
                                        <input type="text" name="emergency_contact" class="form-control" required>
                                        @error('emergency_contact')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Contact Person Name</label>
                                        <input type="text" name="emergency_person" class="form-control" required>
                                        @error('emergency_person')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Relation</label>
                                        <input type="text" name="relation" class="form-control"
                                            placeholder="Ex: Mother" required>
                                        @error('relation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Joining Date</label>
                                        <input type="date" name="joining_date" class="form-control" required>
                                        @error('joining_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Salary</label>
                                        <input type="number" name="salary" class="form-control">
                                        @error('salary')
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
    {{-- <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script> --}}
@endsection
