@extends('employee.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
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

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('error') }}
                    </div>
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
                                <h3 class="widget-user-username text-left">{{ Auth::user()->name }}</h3>
                                <h5 class="widget-user-desc text-left">{{ Auth::user()->designation }}</h5>
                            </div>
                            <div class="widget-user-image">
                                @if (Auth::user()->image && Auth::user()->status == 'active')
                                    <img class="img-circle" style="border: 3px solid #00ff00;"
                                        src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Picture">
                                @elseif (Auth::user()->image && Auth::user()->status == 'inactive')
                                    <img class="img-circle" style="border: 3px solid #ff0000;"
                                        src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Picture">
                                @elseif (!Auth::user()->image && Auth::user()->status == 'inactive')
                                    <img class="img-circle" style="border: 3px solid #ff0000;"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Profile Picture">
                                @else
                                    <img class="img-circle" style="border: 3px solid #00ff00;"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">ID</h5>
                                            <span class="description-text">{{ Auth::user()->id }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">OFFICE</h5>
                                            <span class="description-text">
                                                @foreach ($offices as $office)
                                                    @if ($office->id == Auth::user()->office)
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
                                                    @if ($department->id == Auth::user()->department)
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
                                            <span
                                                class="description-text">{{ \Carbon\Carbon::parse(Auth::user()->joining_date)->format('d M, Y') }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2">
                                        <div class="description-block">
                                            <h5 class="description-header">BLOOD GROUP</h5>
                                            <span><img src="{{ asset('images/blood group.png') }}" width="17px"
                                                    height="25px">
                                                {{ Auth::user()->blood_group ? Auth::user()->blood_group . ' (ve)' : null }}</span>
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
                    <div class="col-md-6">
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
                                            <p class="text-muted">{{ Auth::user()->address }}</p>
                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>
                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse(Auth::user()->dob)->format('d M, Y') }} </p>
                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>
                                            <p class="text-muted">{{ Auth::user()->nid }}</p>
                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>
                                            <p class="text-muted">{{ Auth::user()->mobile }}</p>
                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                                            <p class="text-muted">{{ Auth::user()->email }}</p>
                                            <hr>

                                            <strong><i class="far fa-user mr-1"></i> Emergency Contact</strong>
                                            <p class="text-muted">{{ Auth::user()->emergency_person }}
                                                ({{ Auth::user()->relation }}) - {{ Auth::user()->emergency_contact }}</p>
                                            <hr>

                                            <strong><i class="far fa-regular fa-credit-card mr-1"></i> Account No</strong>
                                            <p class="text-muted">
                                                {{ Auth::user()->account_no ? Auth::user()->account_no : null }}</p>




                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('employee.profile_update') }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf


                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="name" value="{{ Auth::user()->name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        name="email" value="{{ Auth::user()->email }}" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="nid"
                                                        value="{{ Auth::user()->nid }}" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter New Password">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="address" placeholder="Enter Present Address"
                                                        value="{{ old('address', Auth::user()->address) }}">{{ Auth::user()->address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="mobile"
                                                        pattern="\d{11}" maxlength="11"
                                                        value="{{ old('mobile', Auth::user()->mobile) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Blood Group</label>
                                                <div class="col-sm-10">
                                                    <select name="blood_group" class="form-control">

                                                        <option selected disabled>Select Blood Group</option>
                                                        <option value="A+"
                                                            {{ Auth::user()->blood_group == 'A+' ? 'selected' : null }}>A+
                                                        </option>
                                                        <option value="A-"
                                                            {{ Auth::user()->blood_group == 'A-' ? 'selected' : null }}>A-
                                                        </option>
                                                        <option value="B+"
                                                            {{ Auth::user()->blood_group == 'B+' ? 'selected' : null }}>B+
                                                        </option>
                                                        <option value="B-"
                                                            {{ Auth::user()->blood_group == 'B-' ? 'selected' : null }}>B-
                                                        </option>
                                                        <option value="O+"
                                                            {{ Auth::user()->blood_group == 'O+' ? 'selected' : null }}>O+
                                                        </option>
                                                        <option value="O-"
                                                            {{ Auth::user()->blood_group == 'O-' ? 'selected' : null }}>O-
                                                        </option>
                                                        <option value="AB+"
                                                            {{ Auth::user()->blood_group == 'AB+' ? 'selected' : null }}>
                                                            AB+</option>
                                                        <option value="AB-"
                                                            {{ Auth::user()->blood_group == 'AB-' ? 'selected' : null }}>
                                                            AB-</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Emergency Contact</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="emergency_contact"
                                                        pattern="\d{11}" maxlength="11"
                                                        value="{{ old('emergency_contact', Auth::user()->emergency_contact) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Contact Person Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="emergency_person"
                                                        value="{{ old('emergency_person', Auth::user()->emergency_person) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Relation</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="relation"
                                                        value="{{ old('relation', Auth::user()->relation) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Photo (500x500 px)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="image" class="form-control">
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#project"
                                            data-toggle="tab">Project</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline"
                                            data-toggle="tab">Timeline</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="project">

                                        <div class="card-body">
                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Total Project
                                                Assigned</strong>
                                            <p class="text-muted">{{ $assigned }}</p>
                                            <hr>

                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Project Completed</strong>
                                            <p class="text-muted">{{ $completed }}</p>
                                            <hr>

                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Project Ongoing</strong>
                                            <p class="text-muted">{{ $ongoing }}</p>
                                            <hr>

                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Project Pending</strong>
                                            <p class="text-muted">{{ $pending }}</p>
                                            <hr>

                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Ontime Delivery</strong>
                                            <p class="text-muted">{{ $onTimeDelivery }}</p>
                                            <hr>

                                            <strong><i class="fas fa-clipboard-list mr-1"></i> Late Delivery</strong>
                                            <p class="text-muted">{{ $late_Delivery }}</p>


                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="timeline">
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <!-- The time line -->
                                                <div class="timeline">

                                                    @foreach ($resigns as $resign)
                                                        @if ($resign->employee_id == Auth::user()->id)
                                                            <div class="time-label">
                                                                <span
                                                                    class="bg-red">{{ \Carbon\Carbon::parse($resign->date)->format('d M. Y') }}</span>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-user bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header"><a
                                                                            href="#">{{ Auth::user()->name }}</a>
                                                                        resigned!</h3>
                                                                    <div class="timeline-body">
                                                                        Reason : {{ $resign->reason }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                    @foreach ($promotion as $pro)
                                                        @if ($pro->employee_id == Auth::user()->id)
                                                            <!-- timeline time label -->
                                                            <div class="time-label">
                                                                <span
                                                                    class="bg-{{ $pro->promotion_type == 'Promotion' ? 'green' : 'red' }}">{{ \Carbon\Carbon::parse($pro->date)->format('d M. Y') }}</span>
                                                            </div>
                                                            <!-- /.timeline-label -->
                                                            <!-- timeline item -->
                                                            <div>
                                                                <i
                                                                    class="fas fa-user bg-{{ $pro->promotion_type == 'Promotion' ? 'green' : 'red' }}"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header"><a
                                                                            href="#">{{ Auth::user()->name }}</a>
                                                                        {{ $pro->promotion_type == 'Promotion' ? 'promoted to ' : 'demoted to ' }}
                                                                        {{ $pro->designation }}</h3>
                                                                    <div class="timeline-body">
                                                                        Department :
                                                                        @foreach ($departments as $department)
                                                                            @if ($department->id == $pro->department)
                                                                                {{ $department->department_name }}<br>
                                                                            @endif
                                                                        @endforeach

                                                                        Salary : {{ $pro->total_salary }}/-
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END timeline item -->

                                                            @if ($pro->comment)
                                                                <!-- timeline item -->
                                                                <div>
                                                                    <i class="fas fa-comments bg-yellow"></i>
                                                                    <div class="timeline-item">
                                                                        <h3 class="timeline-header">Comment from <a
                                                                                href="#">Admin</a></h3>
                                                                        <div class="timeline-body">
                                                                            {{ $pro->comment }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END timeline item -->
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                    <div class="time-label">
                                                        <span
                                                            class="bg-blue">{{ \Carbon\Carbon::parse(Auth::user()->joining_date)->format('d M. Y') }}</span>
                                                    </div>
                                                    <!-- timeline item -->
                                                    <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header no-border"><a
                                                                    href="#">{{ Auth::user()->name }}</a> joined as
                                                                {{ Auth::user()->joined_as }}</h3>
                                                            <div class="timeline-body">
                                                                Department :
                                                                @foreach ($departments as $department)
                                                                    @if ($department->id == Auth::user()->department)
                                                                        {{ $department->department_name }}<br>
                                                                    @endif
                                                                @endforeach

                                                                Salary : {{ Auth::user()->starting_salary }}/-
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END timeline item -->

                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.card-body -->

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
