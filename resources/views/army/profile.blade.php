@extends('army.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('army.dashboard') }}">Home</a></li>
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
                                style="background: url('../dist/img/army.jpg') center center;">
                                <h3 class="widget-user-username text-left">{{ Auth::guard('army')->user()->name }}</h3>
                                <h5 class="widget-user-desc text-left">{{ Auth::guard('army')->user()->designation }}</h5>
                            </div>
                            <div class="widget-user-image">
                                @if (Auth::guard('army')->user()->image)
                                    <img class="img-circle"
                                        src="{{ asset('storage/' . Auth::guard('army')->user()->image) }}"
                                        alt="Profile Picture" style="width: 90px; height: 90px;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">ID</h5>
                                            <span class="description-text">{{ Auth::guard('army')->user()->id }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Mobile</h5>
                                            <span class="description-text">{{ Auth::guard('army')->user()->mobile }}</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">Email</h5>
                                            <span class="description-text">{{ Auth::guard('army')->user()->email }}</span>
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

                                            <p class="text-muted">{{ Auth::guard('army')->user()->address }}</p>

                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>

                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse(Auth::guard('army')->user()->dob)->format('d M, Y') }}
                                            </p>


                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>

                                            <p class="text-muted">{{ Auth::guard('army')->user()->mobile }}</p>


                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>

                                            <p class="text-muted">{{ Auth::guard('army')->user()->nid }}</p>

                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">{{ Auth::guard('army')->user()->email }}</p>

                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('army.profile_update') }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" id="inputName"
                                                        value="{{ Auth::guard('army')->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control"
                                                        id="inputEmail" value="{{ Auth::guard('army')->user()->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="nid" class="form-control"
                                                        value="{{ Auth::guard('army')->user()->nid }}">
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
                                                    <textarea class="form-control" name="address" value="{{ old('address', Auth::guard('army')->user()->address) }}">{{ Auth::guard('army')->user()->address }}</textarea>
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
                                                <label class="col-sm-2 col-form-label">Photo (500x500 px)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="image" class="form-control" placeholder="(500x500 px)">
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
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
