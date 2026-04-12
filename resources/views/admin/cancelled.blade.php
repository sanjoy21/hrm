@extends('admin.index')

@section('title')
    Cancelled
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cancelled</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Cancelled</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <form action="">

                                    <div class="form-group col-md-4">
                                        <label>Zone</label>
                                        <select name="zonename" class="form-control">
                                            <option value="" disabled selected>Select Zone</option>
                                            <option value="১ উত্তরা" {{ request('zonename') == "১ উত্তরা" ? 'selected' : '' }}>১ উত্তরা</option>
                                            <option value="২ মিরপুর" {{ request('zonename') == "২ মিরপুর" ? 'selected' : '' }}>২ মিরপুর</option>
                                            <option value="৩ মহাখালী" {{ request('zonename') == "৩ মহাখালী" ? 'selected' : '' }}>৩ মহাখালী</option>
                                            <option value="৪ মিরপুর" {{ request('zonename') == "৪ মিরপুর" ? 'selected' : '' }}>৪ মিরপুর</option>
                                            <option value="৫ কারওয়ান বাজার" {{ request('zonename') == "৫ কারওয়ান বাজার" ? 'selected' : '' }}>৫ কারওয়ান বাজার</option>
                                            <option value="৬ উত্তরা" {{ request('zonename') == "৬ উত্তরা" ? 'selected' : '' }}>৬ উত্তরা</option>
                                            <option value="৭ দক্ষিণখান" {{ request('zonename') == "৭ দক্ষিণখান" ? 'selected' : '' }}>৭ দক্ষিণখান</option>
                                            <option value="৮ উত্তরখান" {{ request('zonename') == "৮ উত্তরখান" ? 'selected' : '' }}>৮ উত্তরখান</option>
                                            <option value="৯ ভাটারা" {{ request('zonename') == "৯ ভাটারা" ? 'selected' : '' }}>৯ ভাটারা</option>
                                            <option value="১০ সাতারকুল" {{ request('zonename') == "১০ সাতারকুল" ? 'selected' : '' }}>১০ সাতারকুল</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Filter</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref. No</th>
                                            <th>Zone</th>
                                            <th>Ward</th>
                                            <th>Area</th>
                                            <th>Road</th>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>Owner Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>TL Number</th>
                                            <th>SP</th>
                                            <th>DM</th>
                                            <th>DM 1st Call</th>
                                            <th>DM 2nd Call</th>
                                            <th>DM 3rd Call</th>
                                            <th>Delivery Status</th>
                                            <th>Cancel Date</th>
                                            <th>Reason</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($delivery_status as $delivery)

                                        <tr>
                                            <td>{{ $delivery->ref_no}}</td>
                                            <td>{{ $delivery->zonename}}</td>
                                            <td>{{ $delivery->wardname}}</td>
                                            <td>{{ $delivery->areaname}}</td>
                                            <td>{{ $delivery->roadnumber}}</td>
                                            <td>{{ $delivery->businame}}</td>
                                            <td>{{ $delivery->busitype}}</td>
                                            <td>{{ $delivery->OwnerName}}</td>
                                            <td>{{ $delivery->Mob}}</td>
                                            <td>{{ $delivery->busiadd}}</td>
                                            <td>{{ $delivery->TLNumber}}</td>
                                            <td>
                                                @foreach ($supervisor as $sp )
                                                    @if ($sp->id == $delivery->assigned_sp)
                                                        {{ $sp->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($deliveryman as $dm )
                                                    @if ($dm->id == $delivery->assigned_dm)
                                                        {{ $dm->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $delivery->dm_1st_status}}</td>
                                            <td>{{ $delivery->dm_2nd_status}}</td>
                                            <td>{{ $delivery->dm_3rd_status}}</td>
                                            <td>{{ $delivery->delivery_status}}</td>
                                            <td>{{ $delivery->cancel_date}}</td>
                                            <td>{{ $delivery->cancellation_reason}}</td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @endsection

