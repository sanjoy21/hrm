@extends('admin.index')

@section('title')
    NOC Details
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>NOC Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">NOC Details</li>
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

                                    <h6>
                                        @if ($details->status == 'Applied')
                                            Status: {{ $details->status }}
                                        @elseif ($details->status == 'Approved')
                                            @foreach ($employers as $employer)
                                                @if ($employer->id == $details->approved_by)
                                                    Approved by: {{ $employer->name }}
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($employers as $employer)
                                                @if ($employer->id == $details->approved_by)
                                                    Rejected by: {{ $employer->name }}
                                                @endif
                                            @endforeach
                                        @endif

                                    </h6>
                                    <span class="mailbox-read-time">Applied on:
                                        {{ \Carbon\Carbon::parse($details->created_at)->format('d-m-Y') }}</span>

                                </div>
                                <!-- /.mailbox-read-info -->

                                <div class="mailbox-read-message" id="printArea"
    @if ($details->status == 'Approved') style="background: url('{{ asset('images/approved.png') }}') no-repeat center center;
    background-size: 300px auto; opacity: 0.95;"
    @elseif ($details->status == 'Rejected')
    style="background: url('{{ asset('images/rejected.png') }}') no-repeat center center;
    background-size: 300px auto; opacity: 0.95;" @endif>

    <div class="mailbox-read-message-body">
        <img src="{{ asset('images/rk_logo.jpg') }}" style="padding-bottom: 30px;">
        {!! nl2br(
            strip_tags(
                str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $details->application),
                '<b><strong><font>',
            ),
        ) !!}

    </div>
    {{-- <hr> --}}

    <p class="print-footer">House# 286 (2nd Floor), Road: 19/C, New DOHS Mohakhali, Dhaka-1206<br>
    Phone: 09612220077, e-mail: info@rksoftwarebd.com, website: www.rksoftwarebd.com
    </p>

</div>
                                <!-- /.mailbox-read-message -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">

                                <button class="btn btn-default" onclick="printDiv('printArea')">
                                    <i class="fas fa-print"></i> Print</button>

                                <div class="float-right">
                                    <a href="{{ route('my_noc_list') }}" class="btn btn-default"><i
                                            class="fas fa-reply"></i> Back</a>
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

{{-- @section('customJs')
    <script>
        function printDiv(divId) {
            let content = document.getElementById(divId).innerHTML;
            let myWindow = window.open('', '', 'width=800,height=600');
            myWindow.document.write('<html><head><title>Print</title>');
            myWindow.document.write('</head><body>');
            myWindow.document.write(content);
            myWindow.document.write('</body></html>');
            myWindow.document.close();
            myWindow.print();
        }
    </script>
@endsection --}}

@section('customJs')
    <script>
        function printDiv(divId) {
            let content = document.getElementById(divId).innerHTML;
            let myWindow = window.open('', '', 'width=800,height=600');

            // --- Start of injected CSS for printing ---
            const printStyles = `
                <style>
                    /* Use flexbox for the print content container to manage the layout */
                    .print-container {
                        display: flex;
                        flex-direction: column;
                        min-height: 100vh; /* Ensure it takes full viewport height for correct footer positioning */
                        position: relative; /* Base for the absolute/sticky footer */
                        padding-bottom: 70px; /* Add padding for the footer height */
                    }
                    /* Style for the content/body of the application */
                    .mailbox-read-message-body {
                        flex-grow: 1; /* Allow content to push the footer down */
                        /* Reset margin/padding for main application content if needed */
                    }
                    /* Style for the footer you want at the bottom */
                    .print-footer {
                        position: absolute; /* Position relative to the print-container */
                        bottom: 0;
                        left: 0;
                        right: 0;
                        width: 100%;
                        text-align: center;


                        background-color: white; /* Ensure background is white */
                        z-index: 100;
                    }

                    /* Media query for print-specific page footer for multi-page content */
                    @page {
                        /* This is for print-specific repeating content, but less reliable across browsers for positioning.
                           The absolute/bottom method above is generally better for a single-page document.
                           For multi-page, you'd need a more complex solution using page breaks and repeating elements.
                        */
                    }
                </style>
            `;
            // --- End of injected CSS for printing ---

            myWindow.document.write('<html><head><title>Application Details</title>' + printStyles + '</head><body>');

            // Wrap the content in a container with the new CSS class
            myWindow.document.write('<div class="print-container">');

            // Your existing content
            myWindow.document.write(content);

            myWindow.document.write('</div></body></html>');
            myWindow.document.close();

            // Wait briefly for content to render before printing
            setTimeout(() => {
                myWindow.print();
            }, 500);
        }
    </script>
@endsection
