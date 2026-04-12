@extends('army.index')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('army.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{-- @foreach ($birthday as $bday)
                    @if ($bday->id == Auth::guard('army')->user()->id && \Carbon\Carbon::parse($bday->dob)->isBirthday())
                        <h4 align='center'>
                            <font color='#0000ff'><img src="{{ asset('images/happy-birthday.png') }}" width="35px"
                                    height="35px"> Happy Birthday, {{ $bday->name }}! <img
                                    src="{{ asset('images/happy-birthday.png') }}" width="35px" height="35px"></font>
                        </h4>
                    @elseif(\Carbon\Carbon::parse($bday->dob)->isBirthday())
                        <h4 align='center'>
                            <font color='#0000ff'><img src="{{ asset('images/happy-birthday.png') }}" width="35px"
                                    height="35px"> It's {{ $bday->name }}'s Birthday today! <img
                                    src="{{ asset('images/happy-birthday.png') }}" width="35px" height="35px"></font>
                        </h4>
                    @endif
                @endforeach

                @if ($notice && $notice->expire_date >= \Carbon\Carbon::today()->toDateString())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5>📢 New Notice: {{ $notice->title }} </h5>
                            <span>Published on: {{ \Carbon\Carbon::parse($notice->date)->format('d M, Y') }}</span>
                            <div class="float-right"><a href="{{ route('army.notice', $notice->id) }}"
                                    class="btn btn-sm btn-success">
                                    View
                                </a></div>
                        </div>
                    </div>
                @endif --}}

                {{-- <h5 class="mb-2">Attendance</h5> --}}

                {{-- <div class="row">
                    <!-- Check In -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">

                            <div class="info-box-content text-center">

                                @if ($attendance)
                                    @if ($statusMessage)
                                        <span class="info-box-text"
                                            style="color: {{ $statusMessage == 'You are late today!' ? 'red' : 'green' }}">
                                            {{ $statusMessage }}
                                        </span>
                                    @endif
                                @else
                                    <span class="info-box-text">Check In</span>
                                @endif
                                <span id="checkInTime" class="info-box-number">
                                    <span id="checkInTime">{{ $attendance->check_in_formatted ?? '--:--' }}</span>
                                </span>
                                <button id="checkInBtn" class="btn btn-success mt-2"
                                    {{ $attendance && $attendance->check_in ? 'disabled' : '' }}><i
                                        class="fas fa-business-time"></i>
                                    Check In
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Check Out -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">

                            <div class="info-box-content text-center">
                                <span class="info-box-text">Check Out</span>
                                <span id="checkOutTime" class="info-box-number">
                                    @if ($attendance && $attendance->check_out)
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                    @else
                                        <span id="currentCheckOutTime">--</span>
                                    @endif
                                </span>
                                <button id="checkOutBtn" class="btn btn-danger mt-2"
                                    {{ !$attendance || !$attendance->check_in || $attendance->check_out ? 'disabled' : '' }}><i
                                        class="fas fa-solid fa-clock"></i>
                                    Check Out
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card bg-gradient-light mt-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-calendar-alt"></i> Attendance Calendar</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div> --}}

                {{-- <div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Attendance Details</h5>
                            </div>
                            <div class="modal-body">
                                <p><strong>Check In:</strong> <span id="modalCheckIn"></span></p>

                                <p><strong>Check In Lat-Long:</strong> <span id="modalCheckInLat"></span>, <span
                                        id="modalCheckInLong"></span></p>
                                <p><strong>Check Out:</strong> <span id="modalCheckOut"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $total }}</h3>

                                <p>Total Employee</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('army.employees') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $male }}</h3>

                                <p>Male</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a href="{{ route('army.employees') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $female }}</h3>

                                <p>Female</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a href="{{ route('army.employees') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $total - $at_today }}</h3>

                                <p>Absent Today</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <a href="{{ route('army.attendance') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <h4 class="mt-4 mb-2">Daily Attendance</h4>
                <div class="row">

                    @foreach ($attend as $at)
                        @if ($at->date == date('Y-m-d') && $at->employee->department == 10)
                            @php

                                $onTimeThreshold = strtotime('09:20:59');
                                $checkInTime = strtotime($at->check_in);
                                $cardClass =
                                    $checkInTime <= $onTimeThreshold
                                        ? 'card-success direct-chat-success'
                                        : 'card-danger direct-chat-danger';

                            @endphp
                            <div class="col-md-3">
                                <div class="card {{ $cardClass }} direct-chat">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            @foreach ($employees as $employee)
                                                @if ($employee->id == $at->employee_id)
                                                    <a
                                                        href="{{ route('army.employee_profile', $employee->id) }}">{{ $employee->name }}</a>
                                                @endif
                                            @endforeach
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="direct-chat-messages">
                                            <div class="direct-chat-msg">
                                                @foreach ($employees as $employee)
                                                    @if ($employee->id == $at->employee_id && $employee->image != null)
                                                        <img class="direct-chat-img"
                                                            src="{{ asset('storage/' . $employee->image) }}"
                                                            alt="Profile Picture">
                                                    @elseif($employee->id == $at->employee_id && $employee->image == null)
                                                        <img class="direct-chat-img" src="{{ asset('dist/img/user.jpg') }}"
                                                            alt="Profile Picture">
                                                    @endif
                                                @endforeach

                                                <div class="direct-chat-text">
                                                    Check In: {{ $at->check_in }}<br>
                                                    Check In Lat-Long: {{ $at->check_in_lat }}
                                                    {{ $at->check_in_long }}<br>
                                                    Check Out: {{ $at->check_out ? $at->check_out : 'Not Checked Out' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- /.row -->

                <div class="card bg-gradient-light mt-4">
                    <div class="card-body">
                        <div id="map" style="height: 600px;"></div>

                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
                        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
                        <script src="{{ asset('js/app.js') }}"></script>

                        <script>
                            // ----------------------------------------------------
                            // 🟢 FIX: Define the Leaflet Icon Paths in JavaScript
                            // ----------------------------------------------------

                            // Define the custom Leaflet icon defaults to correctly locate the assets
                            delete L.Icon.Default.prototype._getIconUrl;

                            // Use the Laravel asset helper to point to the images you manually copied
                            L.Icon.Default.mergeOptions({
                                iconRetinaUrl: '{{ asset('images/leaflet/marker-icon-2x.png') }}',
                                iconUrl: '{{ asset('images/leaflet/marker-icon.png') }}',
                                shadowUrl: '{{ asset('images/leaflet/marker-shadow.png') }}',
                            });

                            // --- Map Initialization (remains the same) ---
                            var map = L.map('map').setView([23.8103, 90.4125], 10);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 25
                            }).addTo(map);

                            let deliverymen = @json($deliverymen);
                            let markers = {};

                            deliverymen.forEach(dm => {
                                const lat = dm.check_in_lat;
                                const long = dm.check_in_long;

                                if (lat && long) {
                                    const borderClass = dm.is_on_time ? 'animated-border-green' : 'animated-border-red';

                                    // ----------------------------------------------------
                                    // 🟢 FIX: Simplify Marker Construction
                                    // ----------------------------------------------------

                                    // Create the base Leaflet pin
                                    let baseIcon = new L.Icon.Default();

                                    // Use a single DivIcon to combine the pin and the profile image
                                    var combinedIcon = L.divIcon({
                                        className: 'custom-marker',
                                        html: `
                            <div style="position: relative; width: 40px; height: 80px;">
                                <img src="${baseIcon.options.iconUrl}"
                                     style="width:25px;height:41px; position:absolute; bottom:0; left: 8px;">

                                <img src="${dm.image}"
                                     class="${borderClass}"
                                     style="width:40px;height:40px;border-radius:50%;border: 2px solid white; position:absolute; top:0; left: 0;" />
                            </div>
                        `,
                                        iconSize: [40, 80],
                                        iconAnchor: [20, 80],
                                        popupAnchor: [0, -70]
                                    });

                                    let marker = L.marker([lat, long], {
                                        icon: combinedIcon
                                    }).addTo(map);

                                    // 🟢 FIX: Pop-up now displays Employee Name
                                    marker.bindPopup(`
                        <strong>${dm.employee_name}</strong><br>
                        Employee ID: ${dm.employee_id}<br>
                        Check-In: ${dm.check_in ?? 'N/A'}<br>
                        Check-Out: ${dm.check_out ?? 'N/A'}<br>
                        Status: ${dm.is_on_time ? 'ON TIME' : 'LATE'}
                    `);

                                    markers[dm.employee_id] = marker;
                                }
                            });
                        </script>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInBtn = document.getElementById('checkInBtn');
            const checkOutBtn = document.getElementById('checkOutBtn');
            const checkInTime = document.getElementById('checkInTime');
            const checkOutTime = document.getElementById('checkOutTime');

            // Blade variables from controller
            const hasCheckedIn = @json($attendance && $attendance->check_in);
            const hasCheckedOut = @json($attendance && $attendance->check_out);
            const checkInValue = @json($attendance->check_in ?? null);
            const checkOutValue = @json($attendance->check_out ?? null);

            let currentTimer = null;
            let mode = 'checkin'; // default live clock in check-in box

            // Decide the mode and button state on load
            if (hasCheckedIn && !hasCheckedOut) {
                // Checked in but not out yet
                mode = 'checkout';
                checkInBtn.disabled = true;
                checkOutBtn.disabled = false;
                checkInTime.innerText = checkInValue; // show stored time
            } else if (hasCheckedIn && hasCheckedOut) {
                // Already checked out
                mode = 'none';
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
                checkInTime.innerText = checkInValue;
                checkOutTime.innerText = checkOutValue;
            } else {
                // Not checked in yet
                mode = 'checkin';
                checkInBtn.disabled = false;
                checkOutBtn.disabled = true;
            }

            // Update live time only for the active mode
            function updateTime() {
                const now = new Date();
                const formatted = now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                if (mode === 'checkin') {
                    checkInTime.innerText = formatted;
                } else if (mode === 'checkout') {
                    checkOutTime.innerText = formatted;
                }
            }

            // Start live time update
            if (mode !== 'none') {
                currentTimer = setInterval(updateTime, 1000);
            }

            // Helper for location + AJAX
            function getLocationAndSend(url, disableBtn, enableBtn, timeBox, nextMode = null) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const data = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            _token: "{{ csrf_token() }}"
                        };

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(res => res.json())
                            .then(response => {
                                alert(response.message);
                                const now = new Date().toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });
                                timeBox.innerText = now;

                                disableBtn.disabled = true;
                                if (enableBtn) enableBtn.disabled = false;

                                if (nextMode) {
                                    mode = nextMode;
                                } else {
                                    mode = 'none'; // after checkout stop live time
                                }

                                clearInterval(currentTimer);
                                if (mode !== 'none') {
                                    currentTimer = setInterval(updateTime, 1000);
                                }
                            })
                            .catch(err => alert('Error: ' + err));
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            // Button click handlers
            checkInBtn.addEventListener('click', () => {
                getLocationAndSend("{{ route('army.checkIn') }}", checkInBtn, checkOutBtn, checkInTime,
                    'checkout');
            });

            checkOutBtn.addEventListener('click', () => {
                getLocationAndSend("{{ route('army.checkOut') }}", checkOutBtn, null, checkOutTime,
                    null);
            });
        });
    </script>


    <script>
        $(function() {
            const calendarData = @json($calendarData ?? []);

            function formatDateYMDtoMDY(dateStr) {
                const parts = dateStr.split('-'); // YYYY-MM-DD
                return `${parts[1]}/${parts[2]}/${parts[0]}`; // MM/DD/YYYY
            }

            function colorAttendanceDays() {
                calendarData.forEach(item => {
                    const dateStr = formatDateYMDtoMDY(item.date);
                    const dayCell = $(`#calendar td[data-day='${dateStr}']`);
                    if (dayCell.length) {
                        dayCell.css('background-color', item.color).css('color', '#fff');
                        dayCell.attr('title', item.title);
                    }
                });
            }

            // Initialize AdminLTE inline calendar
            $('#calendar').datetimepicker({
                inline: true,
                format: 'YYYY-MM-DD'
            });

            // Initial coloring
            setTimeout(colorAttendanceDays, 200);

            // Recolor on DOM changes
            const calendarNode = document.getElementById('calendar');
            const observer = new MutationObserver(() => {
                colorAttendanceDays();
            });
            observer.observe(calendarNode, {
                childList: true,
                subtree: true
            });

            // Use the official 'dp.change' event for date selection
            $('#calendar').on('change.datetimepicker', function(e) {
                const selectedDate = e.date; // Moment.js object
                if (!selectedDate) return;
                const dateYMD = selectedDate.format('YYYY-MM-DD');

                const record = calendarData.find(r => r.date === dateYMD);
                if (record) {
                    $('#modalDate').text(dateYMD);
                    $('#modalCheckIn').text(record.check_in || 'Not Checked In');
                    $('#modalCheckOut').text(record.check_out || 'Not Checked Out');
                    $('#modalCheckInLat').text(record.check_in_lat || 'N/A');
                    $('#modalCheckInLong').text(record.check_in_long || 'N/A');

                    let modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    modal.show();
                }
            });
        });
    </script>
@endsection

@section('customCss')
    <style>
        @keyframes pulseGreen {
            0% {
                box-shadow: 0 0 5px 0 rgba(0, 255, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 15px 5px rgba(0, 255, 0, 0.7);
            }

            100% {
                box-shadow: 0 0 5px 0 rgba(0, 255, 0, 0.7);
            }
        }

        @keyframes pulseRed {
            0% {
                box-shadow: 0 0 5px 0 rgba(255, 0, 0, 0.7);
            }

            50% {
                box-shadow: 0 0 15px 5px rgba(255, 0, 0, 0.7);
            }

            100% {
                box-shadow: 0 0 5px 0 rgba(255, 0, 0, 0.7);
            }
        }

        .animated-border-green {
            border: 4px solid green;
            animation: pulseGreen 2s infinite ease-in-out;
        }

        .animated-border-red {
            border: 4px solid red;
            animation: pulseRed 2s infinite ease-in-out;
        }
    </style>
@endsection
