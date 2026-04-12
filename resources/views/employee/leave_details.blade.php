@extends('employee.index')

@section('title')
    Application Details
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Application Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Application Details</li>
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
                                    <h5>
                                        @foreach ($leave_types as $leave_type)
                                            @if ($leave_type->id == $details->leave_type)
                                                {{ $leave_type->leave_name }}
                                            @endif
                                        @endforeach
                                    </h5>
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
                                    <br>

                                    <span class="mailbox-read-time">
                                        @foreach ($leave_types as $leave_type)
                                            @if ($leave_type->id == $details->leave_type && $leave_type->leave_name != "General Application")


                                        @if ($details->from_date == $details->to_date)
                                            Leave Date:
                                            {{ \Carbon\Carbon::parse($details->from_date)->format('d-m-Y') }}
                                            ({{ $details->total_day }} day)
                                        @else
                                            From {{ \Carbon\Carbon::parse($details->from_date)->format('d-m-Y') }} to
                                            {{ \Carbon\Carbon::parse($details->to_date)->format('d-m-Y') }}
                                            ({{ $details->total_day }} days)
                                        @endif
                                        @endif
                                        @endforeach
                                    </span>

                                    @if($details->comment)
                                        <div class="mt-3 p-3 bg-light" style="border-left: 3px solid #007bff;">
                                            <strong><i class="fas fa-comment"></i> Admin Comment:</strong>
                                            <p class="mb-0 mt-1">{{ $details->comment }}</p>
                                        </div>
                                    @endif

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

                                    <p class="print-footer">House# 286 (2nd Floor), Road: 19/C, New DOHS Mohakhali, Dhaka-1206<br>
                                    Phone: 09612220077, e-mail: info@rksoftwarebd.com, website: www.rksoftwarebd.com
                                    </p>
                                </div>
                                <!-- /.mailbox-read-message -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-body">
                                <!-- Attachments Section -->
                                        @if($details->attachments && $details->attachments->count() > 0)
                                            <div class="attachments-section" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-left: 3px solid #007bff; border-radius: 4px;">
                                                <strong style="font-size: 14px; color: #333;">
                                                    <i class="fas fa-paperclip"></i> Attachments ({{ $details->attachments->count() }}):
                                                </strong>
                                                <div style="margin-top: 10px;">
                                                    @foreach($details->attachments as $attachment)
                                                        @php
                                                            $fileExtension = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                                                            $fileIcon = 'fa-file';
                                                            $fileColor = '#6c757d';

                                                            if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                $fileIcon = 'fa-file-image';
                                                                $fileColor = '#28a745';
                                                            } elseif(in_array($fileExtension, ['pdf'])) {
                                                                $fileIcon = 'fa-file-pdf';
                                                                $fileColor = '#dc3545';
                                                            } elseif(in_array($fileExtension, ['doc', 'docx'])) {
                                                                $fileIcon = 'fa-file-word';
                                                                $fileColor = '#007bff';
                                                            } elseif(in_array($fileExtension, ['xls', 'xlsx'])) {
                                                                $fileIcon = 'fa-file-excel';
                                                                $fileColor = '#28a745';
                                                            } elseif(in_array($fileExtension, ['txt'])) {
                                                                $fileIcon = 'fa-file-alt';
                                                                $fileColor = '#17a2b8';
                                                            } elseif(in_array($fileExtension, ['zip', 'rar', '7z'])) {
                                                                $fileIcon = 'fa-file-archive';
                                                                $fileColor = '#ffc107';
                                                            }

                                                            $fileSize = round($attachment->file_size / (1024 * 1024), 2);
                                                        @endphp

                                                        <div style="margin-bottom: 8px; padding: 5px 0; border-bottom: 1px solid #e9ecef;">
                                                            <i class="fas {{ $fileIcon }}" style="color: {{ $fileColor }}; margin-right: 8px;"></i>
                                                            <a href="{{ route('employee.leave.download_attachment', $attachment->id) }}"
                                                               style="text-decoration: none; color: #007bff; margin-right: 10px;">
                                                                {{ $attachment->file_name }}
                                                            </a>
                                                            <span style="font-size: 11px; color: #6c757d;">
                                                                ({{ $fileSize }} MB)
                                                            </span>

                                                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <button type="button"
                                                                        class="btn btn-link btn-sm"
                                                                        style="padding: 0; margin-left: 10px; font-size: 12px;"
                                                                        data-toggle="modal"
                                                                        data-target="#imageModal{{ $attachment->id }}">
                                                                    <i class="fas fa-eye"></i> Preview
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-default" onclick="printDiv('printArea')">
                                    <i class="fas fa-print"></i> Print</button>

                                <div class="float-right">
                                    <a href="{{ route('employee.leave_all') }}" class="btn btn-default"><i
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

    <!-- Image Modals for each attachment -->
    @if($details->attachments && $details->attachments->count() > 0)
        @foreach($details->attachments as $attachment)
            @php
                $fileExtension = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
            @endphp
            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                <div class="modal fade" id="imageModal{{ $attachment->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $attachment->file_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ Storage::url($attachment->file_path) }}" class="img-fluid" alt="{{ $attachment->file_name }}">
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('employee.leave.download_attachment', $attachment->id) }}" class="btn btn-info">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
@endsection

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
                        min-height: 100vh;
                        position: relative;
                        padding-bottom: 70px;
                    }
                    .mailbox-read-message-body {
                        flex-grow: 1;
                    }
                    .print-footer {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        width: 100%;
                        text-align: center;
                        background-color: white;
                        z-index: 100;
                    }

                    /* Print styles for attachments */
                    .attachments-section {
                        margin-top: 30px;
                        padding: 15px;
                        background-color: #f8f9fa !important;
                        border-left: 3px solid #007bff;
                        border-radius: 4px;
                        page-break-inside: avoid;
                    }
                    .attachments-section a {
                        text-decoration: none;
                        color: #007bff !important;
                    }

                    @page {
                        margin: 1.5cm;
                    }

                    @media print {
                        .btn, .modal, .modal-backdrop {
                            display: none !important;
                        }
                        .attachments-section {
                            background-color: #f8f9fa !important;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                    }
                </style>
            `;
            // --- End of injected CSS for printing ---

            myWindow.document.write('<html><head><title>Application Details</title>' + printStyles + '</head><body>');
            myWindow.document.write('<div class="print-container">');
            myWindow.document.write(content);
            myWindow.document.write('</div></body></html>');
            myWindow.document.close();

            setTimeout(() => {
                myWindow.print();
            }, 500);
        }
    </script>
@endsection
