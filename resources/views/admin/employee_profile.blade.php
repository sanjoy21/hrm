@extends('admin.index')

@section('title')
    Employee Profile
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                <h3 class="widget-user-username text-left">{{ $employee->name }}</h3>
                                <h5 class="widget-user-desc text-left">{{ $employee->designation }}</h5>
                            </div>
                            <div class="widget-user-image">
                                @if ($employee->image && $employee->status == 'active')
                                    <img class="img-circle" style="border: 3px solid #00ff00;"
                                        src="{{ asset('storage/' . $employee->image) }}" alt="Profile Picture">
                                @elseif ($employee->image && $employee->status == 'inactive')
                                    <img class="img-circle" style="border: 3px solid #ff0000;"
                                        src="{{ asset('storage/' . $employee->image) }}" alt="Profile Picture">
                                @elseif (!$employee->image && $employee->status == 'inactive')
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
                                            <span class="description-text">{{ $employee->id }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-2 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">OFFICE</h5>
                                            <span class="description-text">
                                                @foreach ($offices as $office)
                                                    @if ($office->id == $employee->office)
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
                                                    @if ($department->id == $employee->department)
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
                                                class="description-text">{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M, Y') }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-2">
                                        <div class="description-block">
                                            <h5 class="description-header">BLOOD GROUP</h5>
                                            <span><img src="{{ asset('images/blood group.png') }}"
                                                    width="17px" height="25px"> {{ $employee->blood_group ? $employee->blood_group ." (ve)" : null}}</span>
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
                                            <p class="text-muted">{{ $employee->address }}</p>
                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>
                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse($employee->dob)->format('d M, Y') }} </p>
                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>
                                            <p class="text-muted">{{ $employee->nid }}</p>
                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>
                                            <p class="text-muted">{{ $employee->mobile }}</p>
                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                                            <p class="text-muted">{{ $employee->email }}</p>
                                            <hr>

                                            <strong><i class="far fa-user mr-1"></i> Emergency Contact</strong>
                                            <p class="text-muted">{{ $employee->emergency_person }}
                                                ({{ $employee->relation }}) - {{ $employee->emergency_contact }}</p>
                                            <hr>

                                            <strong><i class="far fa-regular fa-credit-card mr-1"></i> Account No</strong>
                                            <p class="text-muted">{{ $employee->account_no }}</p>
                                            {{-- <hr> --}}

                                            {{-- <strong><i class="far fa-user mr-1"></i> Experience</strong>
                                            <p class="text-muted">{{ $employee->experience }}</p> --}}


                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('employee_profile_update', $employee->id) }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <select name="status" class="form-control">
                                                        <option selected disabled>Select Status</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName"
                                                        name="name">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        name="email">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" name="nid">
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
                                                        value="{{ old('address', $employee->address) }}">{{ $employee->address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Mobile</label>
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
                                                                {{ $employee->blood_group == "A+" ? 'selected' : null }}>A+</option>
                                                        <option value="A-"
                                                                {{ $employee->blood_group == "A-" ? 'selected' : null }}>A-</option>
                                                        <option value="B+"
                                                                {{ $employee->blood_group == "B+" ? 'selected' : null }}>B+</option>
                                                        <option value="B-"
                                                                {{ $employee->blood_group == "B-" ? 'selected' : null }}>B-</option>
                                                        <option value="O+"
                                                                {{ $employee->blood_group == "O+" ? 'selected' : null }}>O+</option>
                                                        <option value="O-"
                                                                {{ $employee->blood_group == "O-" ? 'selected' : null }}>O-</option>
                                                        <option value="AB+"
                                                                {{ $employee->blood_group == "AB+" ? 'selected' : null }}>AB+</option>
                                                        <option value="AB-"
                                                                {{ $employee->blood_group == "AB-" ? 'selected' : null }}>AB-</option>

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
                                                    <input type="text" class="form-control" name="emergency_person">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Relation</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="relation">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Account No</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="account_no" value="{{ $employee->account_no ? $employee->account_no : null }}">
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
                                            <p class="text-muted">{{ $all_project }}</p>
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
                                                        @if ($resign->employee_id == $employee->id)
                                                            <div class="time-label">
                                                                <span
                                                                    class="bg-red">{{ \Carbon\Carbon::parse($resign->date)->format('d M. Y') }}</span>
                                                            </div>
                                                            <div>
                                                                <i class="fas fa-user bg-red"></i>
                                                                <div class="timeline-item">
                                                                    <h3 class="timeline-header"><a
                                                                            href="#">{{ $employee->name }}</a>
                                                                        resigned!</h3>
                                                                    <div class="timeline-body">
                                                                        Reason : {{ $resign->reason }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                    @foreach ($promotion as $pro)
                                                        @if ($pro->employee_id == $employee->id)
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
                                                                            href="#">{{ $employee->name }}</a>
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
                                                            class="bg-blue">{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M. Y') }}</span>
                                                    </div>
                                                    <!-- timeline item -->
                                                    <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                        <div class="timeline-item">
                                                            <h3 class="timeline-header no-border"><a
                                                                    href="#">{{ $employee->name }}</a> joined as
                                                                {{ $employee->joined_as }}</h3>
                                                            <div class="timeline-body">
                                                                Department :
                                                                @foreach ($departments as $department)
                                                                    @if ($department->id == $employee->department)
                                                                        {{ $department->department_name }}<br>
                                                                    @endif
                                                                @endforeach

                                                                Salary : {{ $employee->starting_salary }}/-
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

                <div class="card bg-gradient-light mt-12">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-calendar-alt"></i> Attendance Calendar</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>

                <div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Attendance Details for <span id="modalDate"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="attendanceDetails">
                                    <!-- Normal attendance details will go here -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-success text-white">
                                                    <h6><i class="fas fa-sign-in-alt"></i> Check In Details</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Time:</strong> <span id="modalCheckIn"></span></p>
                                                    <p><strong>Location (Coordinates):</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckInLat"></span>, <span
                                                            id="modalCheckInLong"></span>
                                                    </div>
                                                    <p><strong>Address:</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckInAddress"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-danger text-white">
                                                    <h6><i class="fas fa-sign-out-alt"></i> Check Out Details</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Time:</strong> <span id="modalCheckOut"></span></p>
                                                    <p><strong>Location (Coordinates):</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckOutLat"></span>, <span
                                                            id="modalCheckOutLong"></span>
                                                    </div>
                                                    <p><strong>Address:</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckOutAddress"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="leaveDetails" style="display: none;">
                                    <!-- Leave details will go here -->
                                    <div class="alert alert-info">
                                        <h5><i class="fas fa-umbrella-beach"></i> You're on Leave</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-2">At a Glance</h5>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Testing Purpose</span>
                                <span class="info-box-number">00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Testing Purpose</span>
                                <span class="info-box-number">00</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('application_all',['employee' => $employee->id]) }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-bug"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Leave Took This Year</span>
                                    <span class="info-box-number">{{ $totalLeaves }} / 20</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('warning_all',['employee' => $employee->id]) }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-skull-crossbones"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Warning</span>
                                    <span class="info-box-number">{{ $warning }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
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
            const calendarData = @json($calendarData ?? []);

            function formatDateYMDtoMDY(dateStr) {
                const parts = dateStr.split('-'); // YYYY-MM-DD
                return `${parts[1]}/${parts[2]}/${parts[0]}`; // MM/DD/YYYY
            }

            function colorAttendanceDays() {
                calendarData.forEach(item => {
                    const dateStr = formatDateYMDtoMDY(item.date);
                    const dayCell = $(`#calendar td[data-day='${dateStr}']`);
                    if (dayCell.length) {
                        dayCell.css('background-color', item.color).css('color', '#fff');
                        dayCell.attr('title', item.title);
                    }
                });
            }

            // Initialize AdminLTE inline calendar
            $('#calendar').datetimepicker({
                inline: true,
                format: 'YYYY-MM-DD'
            });

            // Initial coloring
            setTimeout(colorAttendanceDays, 200);

            // Recolor on DOM changes
            const calendarNode = document.getElementById('calendar');
            const observer = new MutationObserver(() => {
                colorAttendanceDays();
            });
            observer.observe(calendarNode, {
                childList: true,
                subtree: true
            });

            // Use the official 'dp.change' event for date selection
            $('#calendar').on('change.datetimepicker', function(e) {
                const selectedDate = e.date; // Moment.js object
                if (!selectedDate) return;
                const dateYMD = selectedDate.format('YYYY-MM-DD');

                const record = calendarData.find(r => r.date === dateYMD);
                if (record) {
                    $('#modalDate').text(dateYMD);

                    if (record.is_leave) {
                        // Show leave details, hide attendance details
                        $('#attendanceDetails').hide();
                        $('#leaveDetails').show();
                        $('#modalLeaveType').text(record.leave_type);
                    } else {
                        // Show attendance details, hide leave details
                        $('#leaveDetails').hide();
                        $('#attendanceDetails').show();

                        // Check-in details
                        $('#modalCheckIn').text(record.check_in || 'Not Checked In');
                        $('#modalCheckInLat').text(record.check_in_lat || 'N/A');
                        $('#modalCheckInLong').text(record.check_in_long || 'N/A');
                        $('#modalCheckInAddress').text(record.check_in_address || 'N/A');

                        // Check-out details
                        $('#modalCheckOut').text(record.check_out || 'Not Checked Out');
                        $('#modalCheckOutLat').text(record.check_out_lat || 'N/A');
                        $('#modalCheckOutLong').text(record.check_out_long || 'N/A');
                        $('#modalCheckOutAddress').text(record.check_out_address || 'N/A');
                    }

                    let modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    modal.show();
                }
            });
        });
    </script>
@endsection
