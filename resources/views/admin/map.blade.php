@extends('admin.index')

@section('title')
    Map
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Map</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Map</li>
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
                                <form method="GET" action="{{ route('admin.map') }}" class="mb-4">
                                    <div class="row">
                                        <!-- Zone Filter -->
                                        <div class="col-md-4">
                                            <label for="zonename">Zone</label>
                                            <select name="zonename" id="zonename" class="form-control">
                                                <option value="">-- Select Zone --</option>
                                                @foreach (['১ উত্তরা', '২ মিরপুর', '৩ মহাখালী', '৪ মিরপুর', '৫ কারওয়ান বাজার', '৬ উত্তরা', '৭ দক্ষিণখান', '৮ উত্তরখান', '৯ ভাটারা', '১০ সাতারকুল'] as $zone)
                                                    <option value="{{ $zone }}"
                                                        {{ request('zonename') == $zone ? 'selected' : '' }}>
                                                        {{ $zone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Date From -->
                                        <div class="col-md-3">
                                            <label for="from_date">From Date</label>
                                            <input type="date" name="from_date" id="from_date"
                                                value="{{ request('from_date') }}" class="form-control">
                                        </div>

                                        <!-- Date To -->
                                        <div class="col-md-3">
                                            <label for="to_date">To Date</label>
                                            <input type="date" name="to_date" id="to_date"
                                                value="{{ request('to_date') }}" class="form-control">
                                        </div>

                                        <!-- Submit / Reset -->
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                            <a href="{{ route('admin.map') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="card-body">
                                {{-- <pre>{{ print_r($locations->toArray(), true) }}</pre> --}}
                                <div id="map" style="height: 600px;"></div>
                                <div class="mt-3">
                                    <span class="font-weight-bold text-success"><i class="fa-solid fas fa-truck"> Total
                                            Delivered:</i></span> <span id="marker-count">0</span>
                                </div>
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


@section('customCss')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endsection

@section('customJs')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([23.8103, 90.4125], 10);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 22,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var locations = @json($locations);
            var markerCount = 0;

            locations.forEach(function(location) {
                if (location.latitude && location.longitude) {
                    let popupContent = `
                    <strong>${location.businame}</strong><br>
                    👤 Owner: ${location.OwnerName ?? 'N/A'}<br>
                    🏘️ Zone: ${location.zonename ?? 'N/A'}<br>
                    📞 Mobile: ${location.Mob ?? 'N/A'}<br>
                    🏠 Address: ${location.busiadd ?? 'N/A'}<br>
                    📅 Delivery Date: ${location.delivery_date ?? 'N/A'}<br>
                    ✅ Lat-Long: ${location.latitude ?? 'N/A'}, ${location.longitude ?? 'N/A'}
                `;

                    L.marker([location.latitude, location.longitude])
                        .addTo(map)
                        .bindPopup(popupContent);

                    markerCount++;
                }
            });

            document.getElementById('marker-count').textContent = markerCount;
        });
    </script>
@endsection


{{--
Open Street Map

https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png

Carto Light Map

https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png

Carto Dark Map

https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png

Carto Positron Map

https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png

--}}
