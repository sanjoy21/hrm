@extends('admin.index')

@section('title')
    Attendance Report
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Attendance Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Attendance Report</li>
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

                            <div class="card-header bg-light">
                                <h3 class="card-title">Filter Attendance</h3>
                            </div>

                            <div class="card-body">
                                <form method="GET" action="{{ route('attendance_report') }}">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Month</label>
                                            <select class="form-control select2" name="month">
                                                <option value="">All Months</option>
                                                @php
                                                    $months = [
                                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                                    ];
                                                @endphp

                                                @foreach ($months as $num => $name)
                                                    <option value="{{ $num }}" {{ $selected_month == $num ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Year</label>
                                            <select class="form-control select2" name="year">
                                                <option value="">All Years</option>
                                                @foreach ($distinct_years as $year)
                                                    <option value="{{ $year }}" {{ $selected_year == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Employee</label>
                                            <select class="form-control select2" name="employee">
                                                <option value="">All Employees</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ $selected_employee_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                                <a href="{{ route('attendance_report') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <!-- Detailed Report Card -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title">Detailed Attendance Report</h3>
                            </div>
                            <div class="card-body">
                                @if($all->isEmpty())
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-info-circle"></i> No attendance records found for the selected filters.
                                    </div>
                                @else
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th width="5%">No</th>
                                                <th width="15%">Month</th>
                                                <th width="10%">Year</th>
                                                <th width="25%">Employee Name</th>
                                                <th width="15%" class="text-center">In Time Count</th>
                                                <th width="15%" class="text-center">Late Count</th>
                                                <th width="15%" class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                                $totalInTimeAll = 0;
                                                $totalLateAll = 0;
                                                $totalRecordsAll = 0;

                                                // Group by employee and month-year for counting
                                                $employeeMonthStats = [];

                                                foreach ($all as $attendance) {
                                                    $month = \Carbon\Carbon::parse($attendance->date)->format('F');
                                                    $year = \Carbon\Carbon::parse($attendance->date)->format('Y');
                                                    $monthYear = $month . ' ' . $year;
                                                    $employeeId = $attendance->employee_id;
                                                    $employeeName = $attendance->employee->name ?? 'N/A';

                                                    // Initialize if not exists
                                                    if (!isset($employeeMonthStats[$employeeId])) {
                                                        $employeeMonthStats[$employeeId] = [
                                                            'name' => $employeeName,
                                                            'months' => []
                                                        ];
                                                    }

                                                    if (!isset($employeeMonthStats[$employeeId]['months'][$monthYear])) {
                                                        $employeeMonthStats[$employeeId]['months'][$monthYear] = [
                                                            'month' => $month,
                                                            'year' => $year,
                                                            'in_time_count' => 0,
                                                            'late_count' => 0,
                                                            'total_attendance' => 0
                                                        ];
                                                    }

                                                    // Calculate if late
                                                    if ($attendance->check_in) {
                                                        $checkInTime = \Carbon\Carbon::createFromFormat('h:i:s A', $attendance->check_in);
                                                        $lateThreshold = \Carbon\Carbon::createFromFormat('H:i:s', '09:20:59');
                                                        $isLate = $checkInTime->gt($lateThreshold);

                                                        if ($isLate) {
                                                            $employeeMonthStats[$employeeId]['months'][$monthYear]['late_count']++;
                                                            $totalLateAll++;
                                                        } else {
                                                            $employeeMonthStats[$employeeId]['months'][$monthYear]['in_time_count']++;
                                                            $totalInTimeAll++;
                                                        }
                                                        $employeeMonthStats[$employeeId]['months'][$monthYear]['total_attendance']++;
                                                        $totalRecordsAll++;
                                                    }
                                                }
                                            @endphp

                                            @foreach($employeeMonthStats as $employeeId => $employeeData)
                                                @foreach($employeeData['months'] as $monthYear => $monthData)
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $monthData['month'] }}</td>
                                                        <td>{{ $monthData['year'] }}</td>
                                                        <td>{{ $employeeData['name'] }}</td>
                                                        <td class="text-center">
                                                            @if($monthData['in_time_count'] > 0)
                                                                <span class="badge badge-success" style="font-size: 14px; padding: 6px 10px;">
                                                                    {{ $monthData['in_time_count'] }}
                                                                </span>
                                                                @if($monthData['total_attendance'] > 0)
                                                                    <div class="small text-muted">
                                                                        {{ round(($monthData['in_time_count'] / $monthData['total_attendance']) * 100, 1) }}%
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">0</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($monthData['late_count'] > 0)
                                                                <span class="badge badge-danger" style="font-size: 14px; padding: 6px 10px;">
                                                                    {{ $monthData['late_count'] }}
                                                                </span>
                                                                @if($monthData['total_attendance'] > 0)
                                                                    <div class="small text-muted">
                                                                        {{ round(($monthData['late_count'] / $monthData['total_attendance']) * 100, 1) }}%
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">0</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-primary" style="font-size: 14px; padding: 6px 10px;">
                                                                {{ $monthData['total_attendance'] }}
                                                            </span>
                                                            <div class="small text-muted">
                                                                @if($monthData['total_attendance'] > 0)
                                                                    <div class="progress" style="height: 8px; margin: 3px 0;">
                                                                        @if($monthData['in_time_count'] > 0)
                                                                            <div class="progress-bar bg-success"
                                                                                 style="width: {{ ($monthData['in_time_count'] / $monthData['total_attendance']) * 100 }}%"
                                                                                 title="In Time: {{ $monthData['in_time_count'] }}">
                                                                            </div>
                                                                        @endif
                                                                        @if($monthData['late_count'] > 0)
                                                                            <div class="progress-bar bg-danger"
                                                                                 style="width: {{ ($monthData['late_count'] / $monthData['total_attendance']) * 100 }}%"
                                                                                 title="Late: {{ $monthData['late_count'] }}">
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    In Time: {{ $monthData['in_time_count'] }} | Late: {{ $monthData['late_count'] }}
                                                                @else
                                                                    No attendance
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        {{-- <tfoot>
                                            <tr class="bg-light">
                                                <th colspan="4" class="text-right"><strong>GRAND TOTALS:</strong></th>
                                                <th class="text-center">
                                                    <span class="badge badge-success" style="font-size: 16px; padding: 8px 12px;">
                                                        {{ $totalInTimeAll }}
                                                    </span>
                                                    @if($totalRecordsAll > 0)
                                                        <div class="small text-muted">
                                                            {{ round(($totalInTimeAll / $totalRecordsAll) * 100, 1) }}%
                                                        </div>
                                                    @endif
                                                </th>
                                                <th class="text-center">
                                                    <span class="badge badge-warning" style="font-size: 16px; padding: 8px 12px;">
                                                        {{ $totalLateAll }}
                                                    </span>
                                                    @if($totalRecordsAll > 0)
                                                        <div class="small text-muted">
                                                            {{ round(($totalLateAll / $totalRecordsAll) * 100, 1) }}%
                                                        </div>
                                                    @endif
                                                </th>
                                                <th class="text-center">
                                                    <span class="badge badge-primary" style="font-size: 16px; padding: 8px 12px;">
                                                        {{ $totalRecordsAll }}
                                                    </span>
                                                    @if($totalRecordsAll > 0)
                                                        <div class="progress" style="height: 10px; margin: 5px 0;">
                                                            <div class="progress-bar bg-success"
                                                                 style="width: {{ ($totalInTimeAll / $totalRecordsAll) * 100 }}%"
                                                                 title="In Time: {{ $totalInTimeAll }}">
                                                            </div>
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ ($totalLateAll / $totalRecordsAll) * 100 }}%"
                                                                 title="Late: {{ $totalLateAll }}">
                                                            </div>
                                                        </div>
                                                        <div class="small text-muted">
                                                            In Time: {{ $totalInTimeAll }} | Late: {{ $totalLateAll }}
                                                        </div>
                                                    @endif
                                                </th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                @endif
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

@section('customJs')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "Select option",
            allowClear: true
        });

        // Calculate totals and update summary boxes
        function updateSummaryBoxes() {
            let totalInTime = {{ $totalInTimeAll ?? 0 }};
            let totalLate = {{ $totalLateAll ?? 0 }};
            let totalRecords = {{ $totalRecordsAll ?? 0 }};

            // Update summary boxes
            $('#totalInTimeCount').text(totalInTime);
            $('#totalLateCount').text(totalLate);
            $('#totalRecordsCount').text(totalRecords);

            // Update progress bars
            let inTimePercentage = totalRecords > 0 ? (totalInTime / totalRecords * 100) : 0;
            let latePercentage = totalRecords > 0 ? (totalLate / totalRecords * 100) : 0;

            $('.info-box.bg-success .progress-bar').css('width', inTimePercentage + '%');
            $('.info-box.bg-warning .progress-bar').css('width', latePercentage + '%');
        }

        // Initialize DataTable
        $('#attendanceTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[2, 'desc'], [1, 'desc']], // Sort by year desc, then month desc
            "pageLength": 25,
            "language": {
                "search": "Search records:",
                "lengthMenu": "Show _MENU_ records per page",
                "zeroRecords": "No matching records found",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "columnDefs": [
                {
                    "targets": [4, 5, 6], // Columns 5,6,7 (0-indexed) - In Time, Late, Total Attendance
                    "orderable": false
                }
            ]
        });

        // Update summary boxes on page load
        updateSummaryBoxes();

        // Export to Excel
        $('#exportExcel').click(function() {
            let table = $('#attendanceTable').DataTable();
            let data = table.rows({search: 'applied'}).data().toArray();
            let headers = table.columns().header().toArray().map(th => $(th).text());

            // Create CSV content
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += headers.join(",") + "\n";

            data.forEach(row => {
                csvContent += row.join(",") + "\n";
            });

            // Create download link
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "attendance_report_" + new Date().toISOString().slice(0,10) + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>

<style>
    .info-box {
        min-height: 90px;
        margin-bottom: 0;
    }
    .info-box-icon {
        height: 90px;
        line-height: 90px;
    }
    .info-box-text {
        font-size: 14px;
        font-weight: 600;
    }
    .info-box-number {
        font-size: 24px;
        font-weight: 700;
    }
    table.dataTable tbody tr td {
        vertical-align: middle;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-primary {
        background-color: #007bff;
    }
    .badge-secondary {
        background-color: #6c757d;
    }
    .progress {
        border-radius: 3px;
    }
    .progress-bar {
        border-radius: 3px;
    }
</style>
@endsection
