@extends('employee.index')

@section('title')
    Warning
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Warning</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Warning</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
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

                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="mailbox-read-info">
                                    <h5>{{ $warning->title }}</h5>
                                    {{-- <h6>Published on: {{ $warning->date }}</h6> --}}
                                    <span class="mailbox-read-time">Published on:
                                        {{ \Carbon\Carbon::parse($warning->date)->format('d M, Y') }}</span>

                                </div>
                                <!-- /.mailbox-read-info -->

                                <div class="mailbox-read-message">
                                    {!! nl2br(
                                        strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $warning->message), '<b><strong><font>'),
                                    ) !!}


                                </div>
                                <!-- /.mailbox-read-message -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">

                                <div class="float-right">
                                    <form action="{{ route('warning_read', $warning->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="mark_as_read"
                                            value="1">

                                        <button type="submit" class="btn btn-success"
                                            {{ $warning->mark_as_read == 1 ? 'disabled' : '' }}>
                                            Mark as read
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <!-- /.card-footer -->

                        </div>
                        <!-- /.card -->
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
