@extends('employee.index')

@section('title')
    Apply for NOC
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Apply for NOC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Apply for NOC</li>
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
                            <form action="{{ route('employee.noc_application_store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">

                                <div class="form-group col-md-12">
                                    <label>Application</label>
                                    <textarea name="application" id="compose-textarea" class="form-control" style="height: 300px">
                                        <p>{{ date('jS F, Y') }}</p><p>The Chairman<br>RK Software (Bangladesh) Limited<br>House#286 (2nd floor), Road#19/C<br>New DOHS, Mohakhali, Dhaka-1206</p><p>Subject: Application for No Objection Certificate (NOC).</p><p>Dear Sir,</p><p>I beg most respectfully to state that, I am {{ Auth::user()->name }}, an employee of your company, RK Software (Bangladesh) Limited. My designation is {{ Auth::user()->designation }}. I want to apply for a passport. That's why I need a No Objection Certificate.</p><p>I, therefore, pray and hope that you will consider my case and provide me a No Objection Certificate.</p><p>I remain<br>Sir<br>Your most obedient employee</p><p>{{ Auth::user()->name }}<br>{{ Auth::user()->designation }}<br>Mobile: {{ Auth::user()->mobile }}</p><br>
                                    </textarea>
                                    @error('application')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Apply</button>
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
@endsection
