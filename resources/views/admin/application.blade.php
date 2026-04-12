@extends('admin.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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

                                    @foreach ($employees as $employee)
                                        @if ($employee->id == $application->employee_id)
                                            <h4>{{ $employee->name }} - ({{ $employee->designation }})</h4>
                                        @endif
                                    @endforeach

                                    <h5>
                                        @foreach ($leave_types as $leave_type)
                                            @if ($leave_type->id == $application->leave_type)
                                                {{ $leave_type->leave_name }}
                                            @endif
                                        @endforeach
                                    </h5>
                                    <h6>
                                        @if ($application->status == 'Applied')
                                            Status: {{ $application->status }}
                                        @elseif ($application->status == 'Approved')
                                            @foreach ($employers as $employer)
                                                @if ($employer->id == $application->approved_by)
                                                    Approved by: {{ $employer->name }}
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($employers as $employer)
                                                @if ($employer->id == $application->approved_by)
                                                    Rejected by: {{ $employer->name }}
                                                @endif
                                            @endforeach
                                        @endif
                                    </h6>
                                    <span class="mailbox-read-time">Applied on:
                                        {{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y') }}</span>
                                    <br>

                                    <span class="mailbox-read-time">
                                        @foreach ($leave_types as $leave_type)
                                            @if ($leave_type->id == $application->leave_type && $leave_type->leave_name != "General Application")

                                        @if ($application->from_date == $application->to_date)
                                            Leave Date:
                                            {{ \Carbon\Carbon::parse($application->from_date)->format('d-m-Y') }}
                                            ({{ $application->total_day }} day)
                                        @else
                                            From {{ \Carbon\Carbon::parse($application->from_date)->format('d-m-Y') }} to
                                            {{ \Carbon\Carbon::parse($application->to_date)->format('d-m-Y') }}
                                            ({{ $application->total_day }} days)
                                        @endif

                                        @endif
                                        @endforeach
                                    </span>

                                    @if($application->comment)
                                        <div class="mt-3 p-3 bg-light" style="border-left: 3px solid #007bff;">
                                            <strong><i class="fas fa-comment"></i> Admin Comment:</strong>
                                            <p class="mb-0 mt-1">{{ $application->comment }}</p>
                                        </div>
                                    @endif

                                </div>
                                <!-- /.mailbox-read-info -->

                                <div class="mailbox-read-message" id="printArea"
                                    @if ($application->status == 'Approved') style="background: url('{{ asset('images/approved.png') }}') no-repeat center center;
    background-size: 300px auto; opacity: 0.95;"
    @elseif ($application->status == 'Rejected')
    style="background: url('{{ asset('images/rejected.png') }}') no-repeat center center;
    background-size: 300px auto; opacity: 0.95;" @endif>

                                    <div class="mailbox-read-message-body">
                                        <img src="{{ asset('images/rk_logo.jpg') }}" style="padding-bottom: 30px;">
                                        {!! nl2br(
                                            strip_tags(
                                                str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $application->application),
                                                '<b><strong><font>',
                                            ),
                                        ) !!}
                                    </div>

                                    <p class="print-footer">House# 286 (2nd Floor), Road: 19/C, New DOHS Mohakhali,
                                        Dhaka-1206<br>
                                        Phone: 09612220077, e-mail: info@rksoftwarebd.com, website: www.rksoftwarebd.com
                                    </p>

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-body">
                                <!-- Attachments Section -->
                                        @if($application->attachments && $application->attachments->count() > 0)
                                            <div class="attachments-section" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-left: 3px solid #007bff; border-radius: 4px;">
                                                <strong style="font-size: 14px; color: #333;">
                                                    <i class="fas fa-paperclip"></i> Attachments ({{ $application->attachments->count() }}):
                                                </strong>
                                                <div style="margin-top: 10px;">
                                                    @foreach($application->attachments as $attachment)
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
                                                            <a href="{{ route('leave.download_attachment', $attachment->id) }}"
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
                                <div class="float-left">
                                    @if($application->status == 'Applied')
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveModal">
                                            Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                            Reject
                                        </button>
                                    @endif
                                </div>

                                <div class="float-right">
                                    <button class="btn btn-default" onclick="printDiv('printArea')">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    <a href="{{ route('application_all') }}" class="btn btn-default">
                                        <i class="fas fa-reply"></i> Back
                                    </a>
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

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('application_status', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="approveModalLabel">
                            <i class="fas fa-check-circle"></i> Approve Application
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="approved_by" value="{{ Auth::guard('admin')->user()->id }}">
                        <input type="hidden" name="status" value="Approved">

                        <div class="form-group">
                            <label for="comment">Comment (Optional)</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4"
                                placeholder="Enter reason for approval or any additional notes..."></textarea>
                            <small class="form-text text-muted">You can add a comment to inform the employee about the decision.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Are you sure you want to approve this leave application?
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('application_status', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="rejectModalLabel">
                            <i class="fas fa-times-circle"></i> Reject Application
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="approved_by" value="{{ Auth::guard('admin')->user()->id }}">
                        <input type="hidden" name="status" value="Rejected">

                        <div class="form-group">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <textarea name="comment" id="comment" class="form-control" rows="4" required
                                placeholder="Please provide reason for rejection..."></textarea>
                            <small class="form-text text-muted">It's recommended to provide a reason when rejecting an application.</small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Are you sure you want to reject this leave application?
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modals for each attachment -->
    @if($application->attachments && $application->attachments->count() > 0)
        @foreach($application->attachments as $attachment)
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
                                <a href="{{ route('leave.download_attachment', $attachment->id) }}" class="btn btn-info">
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

            const printStyles = `
                <style>
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
                </style>
            `;

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
