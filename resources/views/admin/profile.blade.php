@extends('admin.index')

@section('title')
    Profile
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $error }}

                        </div>
                    @endforeach
                @endif

            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header text-white"
                                style="background: url('../dist/img/photo1.png') center center;">
                                <h3 class="widget-user-username text-left">{{ Auth::guard('admin')->user()->name }}</h3>
                                <h5 class="widget-user-desc text-left">{{ Auth::guard('admin')->user()->designation }}</h5>
                            </div>
                            <div class="widget-user-image">
                                @if (Auth::guard('admin')->user()->image)
                                    <img class="img-circle"
                                        src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}"
                                        alt="Profile Picture" style="width: 90px; height: 90px;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">ID</h5>
                                            <span class="description-text">{{ Auth::guard('admin')->user()->id }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">OFFICE</h5>
                                            <span class="description-text">
                                                @foreach ($offices as $office)
                                                    @if ($office->id == Auth::guard('admin')->user()->office)
                                                        {{ $office->name }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-3 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">DEPARTMENT</h5>
                                            <span class="description-text">
                                                @foreach ($departments as $department)
                                                    @if ($department->id == Auth::guard('admin')->user()->department)
                                                        {{ $department->department_name }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-3 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">JOINED</h5>
                                            <span class="description-text">{{ \Carbon\Carbon::parse(Auth::guard('admin')->user()->joining_date)->format('d M, Y') }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2">
                                        <div class="description-block">
                                            <h5 class="description-header">BLOOD GROUP</h5>
                                            <span><img src="{{ asset('images/blood group.png') }}"
                                                    width="17px" height="25px"> {{ Auth::guard('admin')->user()->blood_group ? Auth::guard('admin')->user()->blood_group ." (ve)" : null}}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#about"
                                            data-toggle="tab">About</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="about">

                                        <div class="card-body">
                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                            <p class="text-muted">{{ Auth::guard('admin')->user()->address }}</p>

                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>

                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse(Auth::guard('admin')->user()->dob)->format('d M, Y') }}
                                            </p>


                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>

                                            <p class="text-muted">{{ Auth::guard('admin')->user()->mobile }}</p>


                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>

                                            <p class="text-muted">{{ Auth::guard('admin')->user()->nid }}</p>

                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">{{ Auth::guard('admin')->user()->email }}</p>

                                            <hr>

                                            <strong><i class="far fa-user mr-1"></i> Emergency Contact</strong>
                                            <p class="text-muted">{{ Auth::guard('admin')->user()->emergency_person }}
                                                ({{ Auth::guard('admin')->user()->relation }}) - {{ Auth::guard('admin')->user()->emergency_contact }}</p>

                                            <hr>

                                            <strong><i class="far fa-regular fa-credit-card mr-1"></i> Account No</strong>

                                            <p class="text-muted">{{ Auth::guard('admin')->user()->account_no ? Auth::guard('admin')->user()->account_no : null }}</p>

                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('admin.profile_update') }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" id="inputName"
                                                        value="{{ Auth::guard('admin')->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control"
                                                        id="inputEmail" value="{{ Auth::guard('admin')->user()->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="nid" class="form-control"
                                                        value="{{ Auth::guard('admin')->user()->nid }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter New Password">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputExperience"
                                                    class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="address" value="{{ old('address', Auth::guard('admin')->user()->address) }}">{{ Auth::guard('admin')->user()->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="mobile"
                                                        pattern="\d{11}" maxlength="11">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Blood Group</label>
                                                <div class="col-sm-10">
                                                    <select name="blood_group" class="form-control">

                                                        <option selected disabled>Select Blood Group</option>
                                                        <option value="A+"
                                                                {{ Auth::guard('admin')->user()->blood_group == "A+" ? 'selected' : null }}>A+</option>
                                                        <option value="A-"
                                                                {{ Auth::guard('admin')->user()->blood_group == "A-" ? 'selected' : null }}>A-</option>
                                                        <option value="B+"
                                                                {{ Auth::guard('admin')->user()->blood_group == "B+" ? 'selected' : null }}>B+</option>
                                                        <option value="B-"
                                                                {{ Auth::guard('admin')->user()->blood_group == "B-" ? 'selected' : null }}>B-</option>
                                                        <option value="O+"
                                                                {{ Auth::guard('admin')->user()->blood_group == "O+" ? 'selected' : null }}>O+</option>
                                                        <option value="O-"
                                                                {{ Auth::guard('admin')->user()->blood_group == "O-" ? 'selected' : null }}>O-</option>
                                                        <option value="AB+"
                                                                {{ Auth::guard('admin')->user()->blood_group == "AB+" ? 'selected' : null }}>AB+</option>
                                                        <option value="AB-"
                                                                {{ Auth::guard('admin')->user()->blood_group == "AB-" ? 'selected' : null }}>AB-</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Emergency Contact</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="emergency_contact"
                                                        pattern="\d{11}" maxlength="11">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Contact Person Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="emergency_person" value="{{ old('emergency_person',Auth::guard('admin')->user()->emergency_person) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Relation</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="relation" value="{{ old('relation',Auth::guard('admin')->user()->relation) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Photo (500x500 px)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="image" class="form-control" placeholder="(500x500 px)">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Account no</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="account_no" value="{{ old('account_no',Auth::guard('admin')->user()->account_no) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-gradient-light mt-4 collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Salary Structure</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <!-- Add responsive wrapper for horizontal scroll on mobile -->
                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-striped"
                                        style="min-width: 500px;">
                                        <thead>
                                            <tr>
                                                <th>Basic</th>
                                                <th>House Rent</th>
                                                <th>Convenience</th>
                                                <th>Medical</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($salaryStructure != null)
                                                <tr>
                                                    <td>{{ $salaryStructure->basic }}</td>
                                                    <td>{{ $salaryStructure->house_rent }}</td>
                                                    <td>{{ $salaryStructure->convenience }}</td>
                                                    <td>{{ $salaryStructure->medical }}</td>
                                                    <td>{{ $salaryStructure->total }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-12 -->

                </div>
                <!-- /.row -->


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
