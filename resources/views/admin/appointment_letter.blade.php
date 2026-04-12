@extends('admin.index')

@section('title')
    Appointment Letter
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Appointment Letter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Appointment Letter</li>
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

                                <div class="mailbox-read-message" id="printArea">

                                    <div class="mailbox-read-message-body">
                                        <img src="{{ asset('images/rk_logo.jpg') }}" style="padding-bottom: auto;">
                                        {{-- This line outputs the raw HTML content stored in the database --}}
                                        {!! $letter->letter !!}
                                    </div>
                                    {{-- <hr> --}}

                                    <p class="print-footer">House# 286 (2nd Floor), Road: 19/C, New DOHS Mohakhali,
                                        Dhaka-1206<br>
                                        Phone: 09612220077, e-mail: info@rksoftwarebd.com, website: www.rksoftwarebd.com
                                    </p>

                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">

                                <div class="float-right">
                                    <button class="btn btn-default" onclick="printDiv('printArea')">
                                        <i class="fas fa-print"></i> Print</button>
                                    <a href="{{ route('appointment_letter_all') }}" class="btn btn-default"><i
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


@section('customJs')
    <script>
        function printDiv(divId) {
            let content = document.getElementById(divId).innerHTML;
            let myWindow = window.open('', '', 'width=800,height=600');

            // Define the height of your header and footer for padding purposes
            const HEADER_HEIGHT = '80px';
            const FOOTER_HEIGHT = '60px';

            // --- Start of injected CSS for printing ---
            const printStyles = `
                <style>
                    /* Base styles for the printed page */
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                    }

                    /* The container for the main content. This is essential for fixed positioning */
                    .print-container {
                        /* Add padding at the top and bottom of the content area
                         * to prevent content from hiding behind the fixed header/footer. */
                        padding-top: ${HEADER_HEIGHT};
                        padding-bottom: ${FOOTER_HEIGHT};
                    }

                    /* ----------------------------------------------------- */
                    /* *** CSS Paged Media Rules (Applies ONLY during print) *** */
                    /* ----------------------------------------------------- */
                    @media print {

                        /* HEADER (Logo) - Fixed to the top of every page */
                        .print-header {

                            top: 0;
                            left: 0;
                            right: 0;
                            height: ${HEADER_HEIGHT}; /* Must match padding-top above */
                            width: 100%;
                            padding: 0 0;
                            text-align: left;
                            background-color: white;
                            border-bottom: 1px solid #ccc; /* Separator line */
                            z-index: 1000;
                        }

                        /* Make sure the image inside the header is visible */
                        .print-header img {
                            padding: 0 0 0 15px !important; /* Adjust padding if needed */
                            max-height: 100%;
                            width: auto;
                        }

                        /* FOOTER - Fixed to the bottom of every page */
                        .print-footer {
                            position: fixed;
                            bottom: 0;
                            left: 0;
                            right: 0;

                            width: 100%;
                            text-align: center;
                            font-size: 10px;

                            background-color: white;
                            border-top: 1px solid #ccc;
                            z-index: 1000;
                        }

                        /* Hide the original header image from the content block
                         * so it only appears once via the fixed header. */
                        .mailbox-read-message-body > img:first-child {
                            display: none;
                        }
                    }

                    /* General styling for the letter body content */
                    .mailbox-read-message-body p,
                    .mailbox-read-message-body ol,
                    .mailbox-read-message-body li {
                        margin-top: 0;
                        margin-bottom: 0.5em;
                    }

                </style>
            `;
            // --- End of injected CSS for printing ---

            myWindow.document.write('<html><head><title>Application Details</title>' + printStyles + '</head><body>');

            // Wrap the content with a header and the main container
            myWindow.document.write('<div class="print-header">');
            // The header content (your logo)
            myWindow.document.write('<img src="{{ asset('images/rk_logo.jpg') }}" style="padding-bottom: 30px;">');
            myWindow.document.write('</div>');

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
