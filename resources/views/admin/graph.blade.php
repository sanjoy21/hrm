@extends('admin.index')

@section('title')
    Graphical Delivery Data
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Graphical Delivery Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Graphical Delivery Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Filter Form -->
                {{-- <form method="GET" action="{{ route('admin.graph') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <a href="{{ route('admin.graph') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form> --}}

                <form method="GET" action="{{ route('admin.graph') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label>Start Time</label>
                            <input type="time" name="start_time" class="form-control" value="{{ $startTime ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control" value="{{ $endTime ?? '' }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end mt-2">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <a href="{{ route('admin.graph') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>


                <!-- Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Pie Chart - Delivered per Zone</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" height="300"></canvas>
                                <div class="text-center mt-2"><strong>{{ $chartSubtitle }}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bar Chart - Delivered per Month</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="barChart" height="300"></canvas>
                                <div class="text-center mt-2"><strong>{{ $chartSubtitle }}</strong></div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-12 mt-4">
                    <div class="card card-info">
                        <div class="card-header"><h3 class="card-title">Line Chart - Delivered per Day</h3></div>
                        <div class="card-body">
                            <canvas id="lineChart" height="100"></canvas>
                            <div class="text-center mt-2"><strong>{{ $chartSubtitle }}</strong></div>
                        </div>
                    </div>
                </div> --}}

                    <div class="col-12 mt-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Line Chart - Delivered per Day</h3>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;" id="lineChartScrollWrapper">
                                    <div id="lineChartContainer" style="min-width: 800px;">
                                        <canvas id="lineChart" height="500"></canvas>
                                    </div>
                                </div>
                                <div class="text-center mt-2"><strong>{{ $chartSubtitle }}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <span class="font-weight-bold text-success">
                            <i class="fas fa-truck"></i> Total Delivered:
                        </span>
                        <span>{{ $totalDelivered }}</span>
                    </div>
                </div>

                <!-- Deliveryman-wise -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Deliveryman-wise Delivered Count</h3>
                            </div>
                            <div class="card-body">
                                @if ($deliverymanData->count())
                                    <div class="d-flex flex-wrap">
                                        @foreach ($deliverymanData as $dm)
                                            <div class="text-center m-3"
                                                title="{{ $dm->name }}: {{ $dm->total }} Delivered">
                                                <img src="{{ $dm->image ? asset('storage/' . $dm->image) : asset('dist/img/user.jpg') }}"
                                                    alt="{{ $dm->name }}" class="rounded-circle shadow-sm mb-1"
                                                    width="64" height="64">
                                                <div
                                                    class="small font-weight-bold {{ $dm->status == 'inactive' ? 'text-danger' : '' }}">
                                                    {{ $dm->name }} <br>{{ 'Delivered : ' . $dm->total }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No data available for selected date range.</p>
                                @endif
                                <div class="text-center mt-2"><strong>{{ $chartSubtitle }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('customJs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const zones = @json(array_keys($deliveredCounts));
        const deliveredZoneData = @json(array_values($deliveredCounts));
        const barLabels = @json($barLabels);
        const barData = @json($barValues);
        const lineLabels = @json($lineLabels);
        const lineData = @json($lineValues);

        const zoneColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#66FF66', '#FF6666', '#9999FF', '#00CED1'
        ];

        // PIE CHART
        new Chart(document.getElementById("pieChart"), {
            type: 'pie',
            data: {
                labels: zones,
                datasets: [{
                    label: 'Delivered',
                    data: deliveredZoneData,
                    backgroundColor: zoneColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // BAR CHART
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Delivered',
                    backgroundColor: '#28a745',
                    data: barData
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.formattedValue} Delivered`;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // LINE CHART WITH FULL DATA AND AUTO-SCROLL TO LAST 30 DAYS
        const lineChartCanvas = document.getElementById("lineChart");
        const chartWrapper = document.getElementById("lineChartScrollWrapper");
        const chartContainer = document.getElementById("lineChartContainer");

        // Dynamic chart width (60px per label)
        const totalLabels = lineLabels.length;
        const chartWidth = totalLabels * 60;
        chartContainer.style.width = chartWidth + 'px';

        new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Delivered',
                    data: lineData,
                    fill: false,
                    borderColor: '#007bff',
                    backgroundColor: '#007bff',
                    tension: 0.3,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.formattedValue} Delivered`;
                            }
                        }
                    },
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Auto-scroll to the right (show last 30 days)
        window.addEventListener('load', function() {
            chartWrapper.scrollLeft = chartWrapper.scrollWidth;
        });
    </script>
@endsection
