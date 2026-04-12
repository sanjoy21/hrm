@extends('management.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                @foreach ($birthday as $bday)
                    @if ($bday->id == Auth::guard('management')->user()->id && \Carbon\Carbon::parse($bday->dob)->isBirthday())
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

                @foreach ($notice as $notice_new)
                @if ($notice_new && $notice_new->expire_date >= \Carbon\Carbon::today()->toDateString())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5>📢 New Notice: {{ $notice_new->title }} </h5>
                            <span>Published on: {{ \Carbon\Carbon::parse($notice_new->date)->format('d M, Y') }}</span>
                            <div class="float-right"><a href="{{ route('management.notice', $notice_new->id) }}"
                                    class="btn btn-sm btn-success">View</a></div>
                        </div>
                    </div>
                @endif
                @endforeach

                @if (empty(Auth::guard('management')->user()->blood_group))
                    <span class="flashing-red">Please add Blood Group from profile.</span>
                @endif

                <h5 class="mb-2">Attendance</h5>

                <div class="row">
                    <!-- Check In -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <div class="info-box-content text-center">
                                @if ($isOnLeaveToday)
                                    <span class="info-box-text text-danger">
                                        <i class="fas fa-umbrella-beach"></i> You are on leave today
                                    </span>
                                    <span id="checkInTime" class="info-box-number">--:--:--</span>
                                    <button id="checkInBtn" class="btn btn-secondary mt-2" disabled>
                                        <i class="fas fa-business-time"></i> Check In
                                    </button>
                                @else
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
                                        <span id="checkInTime">{{ $attendance->check_in_formatted ?? '--:--:--' }}</span>
                                    </span>
                                    <button id="checkInBtn" class="btn btn-success mt-2"
                                        {{ $attendance && $attendance->check_in ? 'disabled' : '' }}>
                                        <i class="fas fa-business-time"></i> Check In
                                    </button>
                                @endif
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
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i:s A') }}
                                    @else
                                        <span id="currentCheckOutTime">--:--:--</span>
                                    @endif
                                </span>
                                <button id="checkOutBtn" class="btn btn-danger mt-2"
                                    {{ !$attendance || !$attendance->check_in || $attendance->check_out || $isOnLeaveToday ? 'disabled' : '' }}>
                                    <i class="fas fa-solid fa-clock"></i> Check Out
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Day Box -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <div class="info-box-content text-center">
                                <span class="info-box-text">
                                    <i class="fas fa-calendar-alt"></i> Day & Date
                                </span>
                                <span id="currentDay" class="info-box-text mt-1">--</span>
                                <span id="currentDate" class="info-box-number">--</span>
                            </div>
                        </div>
                    </div>

                    <!-- Analog Clock Box -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <div class="info-box-content text-center">
                                {{-- <span class="info-box-text">
                                    <i class="fas fa-clock"></i> Current Time
                                </span> --}}
                                <div class="analog-clock-container mt-2 mb-2">
                                    <canvas id="analogClock" width="120" height="120"></canvas>
                                </div>
                                {{-- <span id="digitalTime" class="info-box-number">--:--:--</span> --}}
                            </div>
                        </div>
                    </div>

                </div><!-- /row -->



                <div class="card bg-gradient-light mt-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-calendar-alt"></i> Attendance Calendar</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>

                <h5 class="mb-2">At a Glance</h5>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Employee</span>
                                <span class="info-box-number">{{ $totalEmployee }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Male</span>
                                <span class="info-box-number">{{ $male }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fas fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Female</span>
                                    <span class="info-box-number">{{ $female }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">HQ</span>
                                <span class="info-box-number">{{ $hq ." "."(M: ". $hqMale. " | F: ". $hqFemale.")"}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">DNCC</span>
                                <span class="info-box-number">{{ $dncc ." "."(M: ". $dnccMale. " | F: ". $dnccFemale.")"}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-gray"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">CCC</span>
                                    <span class="info-box-number">{{ $ccc ." "."(M: ". $cccMale. " | F: ". $cccFemale.")"}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4 col-sm-6 col-12">
                        <a href="{{ route('management.leave_all') }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-bug"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Leave Took This Year</span>
                                    <span class="info-box-number">{{ $totalLeaves }} / 20</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->

                {{-- <div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Attendance Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="attendanceDetails">
                                    <!-- Normal attendance details will go here -->
                                    <p><strong>Check In:</strong> <span id="modalCheckIn"></span></p>
                                    <p><strong>Check In Location:</strong> <span id="modalCheckInLat"></span>, <span
                                            id="modalCheckInLong"></span></p>
                                    <p><strong>Check Out:</strong> <span id="modalCheckOut"></span></p>
                                </div>
                                <div id="leaveDetails" style="display: none;">
                                    <!-- Leave details will go here -->
                                    <div class="alert alert-info">
                                        <h5><i class="fas fa-umbrella-beach"></i> You're on Leave</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Attendance Details for <span id="modalDate"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="attendanceDetails">
                                    <!-- Normal attendance details will go here -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-success text-white">
                                                    <h6><i class="fas fa-sign-in-alt"></i> Check In Details</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Time:</strong> <span id="modalCheckIn"></span></p>
                                                    <p><strong>Location (Coordinates):</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckInLat"></span>, <span
                                                            id="modalCheckInLong"></span>
                                                    </div>
                                                    <p><strong>Address:</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckInAddress"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-danger text-white">
                                                    <h6><i class="fas fa-sign-out-alt"></i> Check Out Details</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p><strong>Time:</strong> <span id="modalCheckOut"></span></p>
                                                    <p><strong>Location (Coordinates):</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckOutLat"></span>, <span
                                                            id="modalCheckOutLong"></span>
                                                    </div>
                                                    <p><strong>Address:</strong></p>
                                                    <div class="alert alert-light border">
                                                        <span id="modalCheckOutAddress"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="leaveDetails" style="display: none;">
                                    <!-- Leave details will go here -->
                                    <div class="alert alert-info">
                                        <h5><i class="fas fa-umbrella-beach"></i> You're on Leave</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="mt-4 mb-2">Daily Attendance</h4>
                <form method="GET" action="{{ route('management.dashboard') }}">
                    <div class="form-group col-md-4">
                        <label>Office</label>
                        <select class="form-control select2" style="width: 100%;" name="office" id="officeSelect">
                            <option value="">All Offices</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}"
                                    {{ $selectedOfficeId == $office->id ? 'selected' : '' }}>
                                    {{ $office->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('office')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </form>
                <br>
                <div class="row">
                    @if ($attend->isEmpty())
                        <div class="col-12">
                            <div class="alert alert-info">
                                No attendance records found for the selected office.
                            </div>
                        </div>
                    @else
                        @foreach ($attend as $at)
                            @if ($at->date == date('Y-m-d'))
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
                                                        <a href="{{ route('management.employee_profile', $employee->id) }}">
                                                            {{ $employee->name }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="direct-chat-messages">
                                                <div class="direct-chat-msg">
                                                    @foreach ($employees as $employee)
                                                        @if ($employee->id == $at->employee_id)
                                                            @if ($employee->image != null)
                                                                <img class="direct-chat-img"
                                                                    src="{{ asset('storage/' . $employee->image) }}"
                                                                    alt="Profile Picture">
                                                            @else
                                                                <img class="direct-chat-img"
                                                                    src="{{ asset('dist/img/user.jpg') }}"
                                                                    alt="Profile Picture">
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                    <div class="direct-chat-text">
                                                        Check In: {{ $at->check_in }}<br>
                                                        Check In Lat-Long: {{ $at->check_in_lat }}
                                                        {{ $at->check_in_long }}<br>
                                                        Check Out:
                                                        {{ $at->check_out ? $at->check_out : 'Not Checked Out' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
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
                            delete L.Icon.Default.prototype._getIconUrl;

                            L.Icon.Default.mergeOptions({
                                iconRetinaUrl: '{{ asset('images/leaflet/marker-icon-2x.png') }}',
                                iconUrl: '{{ asset('images/leaflet/marker-icon.png') }}',
                                shadowUrl: '{{ asset('images/leaflet/marker-shadow.png') }}',
                            });

                            // --- Map Initialization ---
                            var map = L.map('map').setView([23.8103, 90.4125], 10);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 25
                            }).addTo(map);

                            let deliverymen = @json($deliverymen);
                            let markers = {};

                            // Clear existing markers if any
                            Object.values(markers).forEach(marker => {
                                map.removeLayer(marker);
                            });
                            markers = {};

                            deliverymen.forEach(dm => {
                                const lat = dm.check_in_lat;
                                const long = dm.check_in_long;

                                if (lat && long) {
                                    const borderClass = dm.is_on_time ? 'animated-border-green' : 'animated-border-red';

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

                                    // Pop-up with employee info
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

                            // Optional: Fit bounds to show all markers
                            if (Object.keys(markers).length > 0) {
                                const group = new L.featureGroup(Object.values(markers));
                                map.fitBounds(group.getBounds().pad(0.1));
                            }

                            // Optional: Add auto-submit on select change
                            document.getElementById('officeSelect').addEventListener('change', function() {
                                this.form.submit();
                            });
                        </script>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button"
            aria-label="Scroll to top">
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
            const isOnLeaveToday = @json($isOnLeaveToday ?? false);

            let currentTimer = null;
            let mode = 'checkin'; // default live clock in check-in box

            // If on leave, disable everything and show appropriate message
            if (isOnLeaveToday) {
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = true;
                mode = 'none';
            }
            // Decide the mode and button state on load
            else if (hasCheckedIn && !hasCheckedOut) {
                // Checked in but not out yet
                mode = 'checkout';
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = false;
                if (checkInTime) checkInTime.innerText = checkInValue; // show stored time
            } else if (hasCheckedIn && hasCheckedOut) {
                // Already checked out
                mode = 'none';
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = true;
                if (checkInTime) checkInTime.innerText = checkInValue;
                if (checkOutTime) checkOutTime.innerText = checkOutValue;
            } else {
                // Not checked in yet
                mode = 'checkin';
                if (checkInBtn) checkInBtn.disabled = false;
                if (checkOutBtn) checkOutBtn.disabled = true;
            }

            // Update live time only for the active mode
            function updateTime() {
                const now = new Date();
                const formatted = now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                if (mode === 'checkin' && checkInTime) {
                    checkInTime.innerText = formatted;
                } else if (mode === 'checkout' && checkOutTime) {
                    const checkOutElement = document.getElementById('currentCheckOutTime');
                    if (checkOutElement) {
                        checkOutElement.innerText = formatted;
                    }
                }
            }

            // Start live time update
            if (mode !== 'none') {
                currentTimer = setInterval(updateTime, 1000);
            }

            // Function to get address from coordinates using reverse geocoding
            function getAddressFromCoordinates(latitude, longitude, callback) {
                // Using OpenStreetMap Nominatim API for reverse geocoding
                const url =
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`;

                fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'User-Agent': 'YourAppName/1.0' // Replace with your app name
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            callback(data.display_name);
                        } else {
                            callback('Address not found');
                        }
                    })
                    .catch(error => {
                        console.error('Error getting address:', error);
                        callback('Address unavailable');
                    });
            }

            // Helper for location + address + AJAX
            function getLocationAndSend(url, disableBtn, enableBtn, timeBox, nextMode = null, isCheckOut = false) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // First get the address from coordinates
                        getAddressFromCoordinates(latitude, longitude, function(address) {
                            const data = {
                                latitude: latitude,
                                longitude: longitude,
                                address: address, // Add address to the data
                                _token: "{{ csrf_token() }}"
                            };

                            fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify(data)
                                })
                                .then(res => res.json())
                                .then(response => {
                                    if (response.is_on_leave) {
                                        alert(response.message);
                                        // Reload page to show leave message
                                        location.reload();
                                        return;
                                    }

                                    alert(response.message);
                                    const now = new Date().toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        second: '2-digit'
                                    });

                                    if (timeBox) {
                                        if (timeBox.id === 'checkInTime') {
                                            timeBox.innerText = now;
                                        } else {
                                            const checkOutElement = document.getElementById(
                                                'currentCheckOutTime');
                                            if (checkOutElement) {
                                                checkOutElement.innerText = now;
                                            }
                                        }
                                    }

                                    if (disableBtn) disableBtn.disabled = true;
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
                                .catch(err => {
                                    console.error('Error:', err);
                                    alert('Error occurred while processing your request.');
                                });
                        });
                    }, function(error) {
                        let errorMessage = 'Unable to get your location. ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Please enable location access.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Location information is unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Location request timed out.';
                                break;
                            default:
                                errorMessage += 'An unknown error occurred.';
                        }
                        alert(errorMessage);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            // Button click handlers
            if (checkInBtn) {
                checkInBtn.addEventListener('click', () => {
                    if (isOnLeaveToday) {
                        alert('You cannot check in as you are on leave today.');
                        return;
                    }
                    const confirmCheckIn = confirm("Are you sure you want to Check In?");
                    if (confirmCheckIn) {
                        getLocationAndSend("{{ route('management.checkIn') }}", checkInBtn, checkOutBtn,
                            checkInTime, 'checkout', false);
                    }
                });
            }

            if (checkOutBtn) {
                checkOutBtn.addEventListener('click', () => {
                    const confirmCheckOut = confirm("Are you sure you want to Check Out?");
                    if (confirmCheckOut) {
                        getLocationAndSend("{{ route('management.checkOut') }}", checkOutBtn, null,
                            document.getElementById('currentCheckOutTime'), null, true);
                    }
                });
            }
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

                    if (record.is_leave) {
                        // Show leave details, hide attendance details
                        $('#attendanceDetails').hide();
                        $('#leaveDetails').show();
                        $('#modalLeaveType').text(record.leave_type);
                    } else {
                        // Show attendance details, hide leave details
                        $('#leaveDetails').hide();
                        $('#attendanceDetails').show();

                        // Check-in details
                        $('#modalCheckIn').text(record.check_in || 'Not Checked In');
                        $('#modalCheckInLat').text(record.check_in_lat || 'N/A');
                        $('#modalCheckInLong').text(record.check_in_long || 'N/A');
                        $('#modalCheckInAddress').text(record.check_in_address || 'N/A');

                        // Check-out details
                        $('#modalCheckOut').text(record.check_out || 'Not Checked Out');
                        $('#modalCheckOutLat').text(record.check_out_lat || 'N/A');
                        $('#modalCheckOutLong').text(record.check_out_long || 'N/A');
                        $('#modalCheckOutAddress').text(record.check_out_address || 'N/A');
                    }

                    let modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    modal.show();
                }
            });
        });
    </script>

    <script>
        // Function to update date, day, and clock
        function updateDateTime() {
            const now = new Date();

            // Format options for date
            const dateOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            // Format options for day
            const dayOptions = {
                weekday: 'long'
            };

            // Update date and day
            const currentDateElement = document.getElementById('currentDate');
            const currentDayElement = document.getElementById('currentDay');

            if (currentDateElement) {
                currentDateElement.textContent = now.toLocaleDateString(undefined, dateOptions);
            }

            if (currentDayElement) {
                currentDayElement.textContent = now.toLocaleDateString(undefined, dayOptions);
            }

            // Update digital time
            const digitalTimeElement = document.getElementById('digitalTime');
            if (digitalTimeElement) {
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                digitalTimeElement.textContent = now.toLocaleTimeString(undefined, timeOptions);
            }

            // Draw analog clock
            drawAnalogClock(now);
        }

        // Function to draw analog clock
        // function drawAnalogClock(time) {
        //     const canvas = document.getElementById('analogClock');
        //     if (!canvas) return;

        //     const ctx = canvas.getContext('2d');
        //     const radius = canvas.width / 2;

        //     // Clear canvas
        //     ctx.clearRect(0, 0, canvas.width, canvas.height);

        //     // Draw clock face
        //     ctx.beginPath();
        //     ctx.arc(radius, radius, radius - 5, 0, 2 * Math.PI);
        //     ctx.fillStyle = '#ffffff';
        //     ctx.fill();
        //     ctx.strokeStyle = '#333333';
        //     ctx.lineWidth = 2;
        //     ctx.stroke();

        //     // Draw hour markers
        //     for (let i = 0; i < 12; i++) {
        //         const angle = (i * 30 - 90) * Math.PI / 180;
        //         const startX = radius + (radius - 10) * Math.cos(angle);
        //         const startY = radius + (radius - 10) * Math.sin(angle);
        //         const endX = radius + (radius - 5) * Math.cos(angle);
        //         const endY = radius + (radius - 5) * Math.sin(angle);

        //         ctx.beginPath();
        //         ctx.moveTo(startX, startY);
        //         ctx.lineTo(endX, endY);
        //         ctx.strokeStyle = '#333333';
        //         ctx.lineWidth = 2;
        //         ctx.stroke();
        //     }

        //     // Draw numbers
        //     ctx.font = 'bold 12px Arial';
        //     ctx.fillStyle = '#333333';
        //     ctx.textAlign = 'center';
        //     ctx.textBaseline = 'middle';

        //     for (let i = 1; i <= 12; i++) {
        //         const angle = (i * 30 - 90) * Math.PI / 180;
        //         const x = radius + (radius - 18) * Math.cos(angle);
        //         const y = radius + (radius - 18) * Math.sin(angle);
        //         ctx.fillText(i.toString(), x, y);
        //     }

        //     // Get time values
        //     const hours = time.getHours() % 12;
        //     const minutes = time.getMinutes();
        //     const seconds = time.getSeconds();

        //     // Draw hour hand
        //     const hourAngle = (hours * 30 + minutes * 0.5 - 90) * Math.PI / 180;
        //     ctx.beginPath();
        //     ctx.moveTo(radius, radius);
        //     ctx.lineTo(
        //         radius + (radius - 35) * Math.cos(hourAngle),
        //         radius + (radius - 35) * Math.sin(hourAngle)
        //     );
        //     ctx.strokeStyle = '#333333';
        //     ctx.lineWidth = 3;
        //     ctx.stroke();

        //     // Draw minute hand
        //     const minuteAngle = (minutes * 6 + seconds * 0.1 - 90) * Math.PI / 180;
        //     ctx.beginPath();
        //     ctx.moveTo(radius, radius);
        //     ctx.lineTo(
        //         radius + (radius - 25) * Math.cos(minuteAngle),
        //         radius + (radius - 25) * Math.sin(minuteAngle)
        //     );
        //     ctx.strokeStyle = '#666666';
        //     ctx.lineWidth = 2;
        //     ctx.stroke();

        //     // Draw second hand
        //     const secondAngle = (seconds * 6 - 90) * Math.PI / 180;
        //     ctx.beginPath();
        //     ctx.moveTo(radius, radius);
        //     ctx.lineTo(
        //         radius + (radius - 20) * Math.cos(secondAngle),
        //         radius + (radius - 20) * Math.sin(secondAngle)
        //     );
        //     ctx.strokeStyle = '#ff0000';
        //     ctx.lineWidth = 1;
        //     ctx.stroke();

        //     // Draw center dot
        //     ctx.beginPath();
        //     ctx.arc(radius, radius, 4, 0, 2 * Math.PI);
        //     ctx.fillStyle = '#333333';
        //     ctx.fill();
        // }

        function drawAnalogClock(time) {
            const canvas = document.getElementById('analogClock');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const radius = canvas.width / 2;

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw clock face
            ctx.beginPath();
            ctx.arc(radius, radius, radius - 5, 0, 2 * Math.PI);
            ctx.fillStyle = '#ffffff';
            ctx.fill();
            ctx.strokeStyle = '#333333';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Draw hour markers
            for (let i = 0; i < 12; i++) {
                const angle = (i * 30 - 90) * Math.PI / 180;
                const startX = radius + (radius - 10) * Math.cos(angle);
                const startY = radius + (radius - 10) * Math.sin(angle);
                const endX = radius + (radius - 5) * Math.cos(angle);
                const endY = radius + (radius - 5) * Math.sin(angle);

                ctx.beginPath();
                ctx.moveTo(startX, startY);
                ctx.lineTo(endX, endY);
                ctx.strokeStyle = '#333333';
                ctx.lineWidth = 2;
                ctx.stroke();
            }

            // Draw numbers with rainbow gradient
            ctx.font = 'bold 12px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            for (let i = 1; i <= 12; i++) {
                const angle = (i * 30 - 90) * Math.PI / 180;
                const x = radius + (radius - 18) * Math.cos(angle);
                const y = radius + (radius - 18) * Math.sin(angle);

                // Calculate hue based on position (0 to 360 degrees)
                const hue = (i * 30) % 360;
                ctx.fillStyle = `hsl(${hue}, 80%, 50%)`;
                ctx.fillText(i.toString(), x, y);
            }

            // Rest of the code remains the same...
            // Get time values
            const hours = time.getHours() % 12;
            const minutes = time.getMinutes();
            const seconds = time.getSeconds();

            // Draw hour hand
            const hourAngle = (hours * 30 + minutes * 0.5 - 90) * Math.PI / 180;
            ctx.beginPath();
            ctx.moveTo(radius, radius);
            ctx.lineTo(
                radius + (radius - 35) * Math.cos(hourAngle),
                radius + (radius - 35) * Math.sin(hourAngle)
            );
            ctx.strokeStyle = '#333333';
            ctx.lineWidth = 3;
            ctx.stroke();

            // Draw minute hand
            const minuteAngle = (minutes * 6 + seconds * 0.1 - 90) * Math.PI / 180;
            ctx.beginPath();
            ctx.moveTo(radius, radius);
            ctx.lineTo(
                radius + (radius - 25) * Math.cos(minuteAngle),
                radius + (radius - 25) * Math.sin(minuteAngle)
            );
            ctx.strokeStyle = '#666666';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Draw second hand
            const secondAngle = (seconds * 6 - 90) * Math.PI / 180;
            ctx.beginPath();
            ctx.moveTo(radius, radius);
            ctx.lineTo(
                radius + (radius - 20) * Math.cos(secondAngle),
                radius + (radius - 20) * Math.sin(secondAngle)
            );
            ctx.strokeStyle = '#ff0000';
            ctx.lineWidth = 1;
            ctx.stroke();

            // Draw center dot
            ctx.beginPath();
            ctx.arc(radius, radius, 4, 0, 2 * Math.PI);
            ctx.fillStyle = '#333333';
            ctx.fill();
        }


        // Initialize and update every second
        document.addEventListener('DOMContentLoaded', function() {
            // Initial update
            updateDateTime();

            // Update every second
            setInterval(updateDateTime, 1000);

            // Optional: Resize canvas if needed
            window.addEventListener('resize', function() {
                updateDateTime(); // Redraw clock on resize
            });
        });
    </script>


@endsection

{{-- @section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInBtn = document.getElementById('checkInBtn');
            const checkOutBtn = document.getElementById('checkOutBtn');
            const checkInTime = document.getElementById('checkInTime');
            const checkOutTime = document.getElementById('checkOutTime');
            const currentCheckOutTime = document.getElementById('currentCheckOutTime');

            // Blade variables from controller
            const hasCheckedIn = @json($attendance && $attendance->check_in);
            const hasCheckedOut = @json($attendance && $attendance->check_out);
            const checkInValue = @json($attendance->check_in ?? null);
            const checkOutValue = @json($attendance->check_out ?? null);
            const isOnLeaveToday = @json($isOnLeaveToday ?? false);

            let currentTimer = null;
            let mode = 'checkin'; // default live clock in check-in box

            // If on leave, disable everything and show appropriate message
            if (isOnLeaveToday) {
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = true;
                mode = 'none';
            }
            // Decide the mode and button state on load
            else if (hasCheckedIn && !hasCheckedOut) {
                // Checked in but not out yet
                mode = 'checkout';
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = false;
                if (checkInTime) {
                    if (checkInTime.id === 'checkInTime') {
                        checkInTime.innerText = checkInValue; // show stored time
                    }
                }
            } else if (hasCheckedIn && hasCheckedOut) {
                // Already checked out
                mode = 'none';
                if (checkInBtn) checkInBtn.disabled = true;
                if (checkOutBtn) checkOutBtn.disabled = true;
                if (checkInTime) {
                    if (checkInTime.id === 'checkInTime') {
                        checkInTime.innerText = checkInValue;
                    }
                }
                if (checkOutTime) {
                    if (checkOutTime.id === 'checkOutTime') {
                        checkOutTime.innerText = checkOutValue;
                    }
                }
            } else {
                // Not checked in yet
                mode = 'checkin';
                if (checkInBtn) checkInBtn.disabled = false;
                if (checkOutBtn) checkOutBtn.disabled = true;
            }

            // Update live time only for the active mode
            function updateTime() {
                const now = new Date();
                const formatted = now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                if (mode === 'checkin' && checkInTime) {
                    if (checkInTime.id === 'checkInTime') {
                        checkInTime.innerText = formatted;
                    }
                } else if (mode === 'checkout') {
                    if (currentCheckOutTime) {
                        currentCheckOutTime.innerText = formatted;
                    }
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
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(data)
                            })
                            .then(res => res.json())
                            .then(response => {
                                if (response.is_on_leave) {
                                    alert(response.message);
                                    // Reload page to show leave message
                                    location.reload();
                                    return;
                                }

                                alert(response.message);
                                const now = new Date().toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });

                                if (timeBox) {
                                    if (timeBox.id === 'checkInTime') {
                                        timeBox.innerText = now;
                                    } else if (currentCheckOutTime) {
                                        currentCheckOutTime.innerText = now;
                                    }
                                }

                                if (disableBtn) disableBtn.disabled = true;
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
                            .catch(err => {
                                console.error('Error:', err);
                                alert('Error occurred while processing your request.');
                            });
                    }, function(error) {
                        let errorMessage = 'Unable to get your location. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Please enable location access.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Location information is unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Location request timed out.';
                                break;
                            default:
                                errorMessage += 'An unknown error occurred.';
                        }
                        alert(errorMessage);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            // Button click handlers
            if (checkInBtn) {
                checkInBtn.addEventListener('click', () => {
                    if (isOnLeaveToday) {
                        alert('You cannot check in as you are on leave today.');
                        return;
                    }
                    const confirmCheckIn = confirm("Are you sure you want to Check In?");
                    if (confirmCheckIn) {
                        getLocationAndSend("{{ route('management.checkIn') }}", checkInBtn, checkOutBtn, checkInTime, 'checkout');
                    }
                });
            }

            if (checkOutBtn) {
                checkOutBtn.addEventListener('click', () => {
                    const confirmCheckOut = confirm("Are you sure you want to Check Out?");
                    if (confirmCheckOut) {
                        getLocationAndSend("{{ route('management.checkOut') }}", checkOutBtn, null, checkOutTime, null);
                    }
                });
            }
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

                    if (record.is_leave) {
                        // Show leave details, hide attendance details
                        $('#attendanceDetails').hide();
                        $('#leaveDetails').show();
                        $('#modalLeaveType').text(record.leave_type);
                    } else {
                        // Show attendance details, hide leave details
                        $('#leaveDetails').hide();
                        $('#attendanceDetails').show();
                        $('#modalCheckIn').text(record.check_in || 'Not Checked In');
                        $('#modalCheckInLat').text(record.check_in_lat || 'N/A');
                        $('#modalCheckInLong').text(record.check_in_long || 'N/A');
                        $('#modalCheckOut').text(record.check_out || 'Not Checked Out');
                    }

                    let modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    modal.show();
                }
            });
        });
    </script>
@endsection --}}

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

    <style>
        .flashing-red {
            color: red;
            animation: simpleFlash 0.8s infinite;
            font-weight: bold;
        }

        @keyframes simpleFlash {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>

    <style>
        /* Analog Clock Styles */
        .analog-clock-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }

        #analogClock {
            background-color: #f8f9fa;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 120px;
            max-height: 90px;
        }

        /* Date and Day Styles */
        #currentDate {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        #currentDay {
            font-size: 1.2rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #digitalTime {
            font-size: 1rem;
            font-weight: 500;
            color: #007bff;
            margin-top: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #analogClock {
                max-width: 100px;
                max-height: 100px;
            }

            #currentDate {
                font-size: 1rem;
            }

            #currentDay {
                font-size: 0.9rem;
            }
        }
    </style>
@endsection
