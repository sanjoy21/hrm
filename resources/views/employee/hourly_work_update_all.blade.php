@extends('employee.index')

@section('title')
    All Work Update
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Work Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Work Update</li>
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
                                <h3 class="card-title">All Work Update List</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>9-10</th>
                                            <th>10-11</th>
                                            <th>11-12</th>
                                            <th>12-1</th>
                                            <th>1-2</th>
                                            <th>2-3</th>
                                            <th>3-4</th>
                                            <th>4-5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($updates as $update)
                                            <tr>

                                                <td>{{ \Carbon\Carbon::parse($update->date)->format('d-m-Y') }}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t9_10),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t10_11),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t11_12),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t12_1),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t1_2),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t2_3),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t3_4),
                                                '<b><strong><font>',),) !!}</td>
                                                <td>{!! nl2br(strip_tags(str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $update->t4_5),
                                                '<b><strong><font>',),) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

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
