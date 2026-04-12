@extends('admin.index')

@section('title')
    Project Details
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Project Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Project Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
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

                <div class="card-header">
                    <h3 class="card-title">{{ $project->project_name }}</h3><br>
                    <span class="mailbox-read-time">Assigned By:
                        @foreach ($employers as $employer)
                            @if ($employer->id == $project->employer)
                                {{ $employer->name }}
                            @endif
                        @endforeach
                    </span>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Assigned On</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ \Carbon\Carbon::parse($project->assign_date)->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Deadline</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ \Carbon\Carbon::parse($project->deadline)->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Status</span>
                                            <span class="info-box-number text-center text-muted mb-0">{{ $project->status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mailbox-read-message">
                                        <h4>Details</h4>
                                        <hr>
                                        {!! nl2br(
                                            strip_tags(
                                                str_replace(['<p>', '</p>', '<br>', '<br/>', '<br />'], "\n", $project->project_details),
                                                '<b><strong><font>',
                                            ),
                                        ) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <div class="card card-widget widget-user-2">
                                <div class="widget-user-header bg-warning">
                                    <div class="widget-user-image">
                                        @foreach ($employees as $emp)
                                            @if ($project->employee == $emp->id)
                                                @if ($emp->image && $emp->status == 'active')
                                                    <img class="img-circle elevation-2" style="border: 3px solid #00ff00;" src="{{ asset('storage/' . $emp->image) }}" alt="Profile Picture" width="65px" height="65px">
                                                @elseif ($emp->image && $emp->status == 'inactive')
                                                    <img class="img-circle elevation-2" style="border: 3px solid #ff0000;" src="{{ asset('storage/' . $emp->image) }}" alt="Profile Picture" width="65px" height="65px">
                                                @elseif (!$emp->image && $emp->status == 'inactive')
                                                    <img class="img-circle elevation-2" style="border: 3px solid #ff0000;" src="{{ asset('dist/img/user.jpg') }}" alt="Profile Picture">
                                                @else
                                                    <img class="img-circle elevation-2" style="border: 3px solid #00ff00;" src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    <h3 class="widget-user-username">
                                        @foreach ($employees as $employee)
                                            @if ($employee->id == $project->employee)
                                                {{ $employee->name }}
                                            @endif
                                        @endforeach
                                    </h3>
                                    <h5 class="widget-user-desc">
                                        @foreach ($employees as $employee)
                                            @if ($employee->id == $project->employee)
                                                {{ $employee->designation }}
                                            @endif
                                        @endforeach
                                    </h5>
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Total Assigned Project <span class="float-right badge bg-primary">
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $project->employee)
                                                            {{ $project->where('employee', $project->employee)->count() }}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Ongoing Project <span class="float-right badge bg-info">
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $project->employee)
                                                            {{ $project->where('employee', $project->employee)->where('status', 'Ongoing')->count() }}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Pending Project <span class="float-right badge bg-info">
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $project->employee)
                                                            {{ $project->where('employee', $project->employee)->where('status', 'Pending')->count() }}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                On Time Delivery <span class="float-right badge bg-success">{{ $project->where('employee', $project->employee)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Late Delivery <span class="float-right badge bg-danger">{{ $project->where('employee', $project->employee)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Total Completed Project <span class="float-right badge bg-info">
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $project->employee)
                                                            {{ $project->where('employee', $project->employee)->where('status', 'Completed')->count() }}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @foreach ($employees as $employee)
                                    @if ($employee->id == $project->employee)
                                        <a href="{{ route('employee_profile', $employee->id) }}" class="btn btn-success">
                                            <i class="fas fa-eye"></i> View Profile
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            @if ($project->submission_date != null)
                                <p>Submission Date: {{ \Carbon\Carbon::parse($project->submission_date)->format('d-m-Y') }}</p>
                            @endif

                            <!-- Comments Section -->

                                <div>
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                            <h3 class="card-title"><i class="fas fa-comments"></i> Discussion</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Chat History -->
                                            <div class="direct-chat-messages" style="height: 400px; overflow-y: auto;" id="chat-messages">
                                                @if(isset($comments) && count($comments) > 0)
                                                    @foreach($comments as $comment)
                                                        <div class="direct-chat-msg {{ $comment->user_role == 'admin' ? 'right' : '' }}">
                                                            <div class="direct-chat-infos clearfix">
                                                                <span class="direct-chat-name {{ $comment->user_role == 'admin' ? 'float-right' : 'float-left' }}">
                                                                    {{ $comment->user->name }}
                                                                    {{-- <small class="text-muted">
                                                                        ({{ $comment->user_role == 'admin' ? 'Admin' : 'Employee' }})
                                                                    </small> --}}
                                                                </span>
                                                                <span class="direct-chat-timestamp {{ $comment->user_role == 'admin' ? 'float-left' : 'float-right' }}">
                                                                    {{ $comment->created_at->format('d M, Y h:i A') }}
                                                                </span>
                                                            </div>
                                                            <div class="direct-chat-text {{ $comment->user_role == 'admin' ? 'bg-warning' : 'bg-info' }}" style="border-radius: 10px;">
                                                                {!! nl2br(e($comment->comment)) !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-center text-muted py-5">
                                                        <i class="fas fa-comment-dots fa-3x mb-3"></i>
                                                        <p>No messages yet. Start the discussion!</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Comment Form -->
                                            <div class="mt-3">
                                                <form action="{{ route('admin.project_comment', $project->id) }}" method="POST">
                                                    @csrf
                                                    <div class="input-group">
                                                        <textarea name="comment" class="form-control" placeholder="Write your comment here..." rows="2" required></textarea>
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-paper-plane"></i> Send
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('comment')
                                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                                    @enderror
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{ route('project_all') }}" class="btn btn-default"><i class="fas fa-reply"></i> Back</a>
                    </div>
                    <a href="{{ route('project_edit', $project->id) }}" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                    <a href="{{ route('project_delete', $project->id) }}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-danger">
                        <i class="far fa-trash-alt"></i> Delete
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Auto scroll to bottom of chat
        const chatMessages = document.getElementById('chat-messages');
        if(chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
@endsection
