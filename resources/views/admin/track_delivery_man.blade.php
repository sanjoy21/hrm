@extends('admin.index')

@section('title')
    Track Delivery Man
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Track Delivery Man</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Track Delivery Man</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <div id="map" style="height: 600px;"></div>

                                <!-- Leaflet -->
                                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
                                <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

                                <!-- Laravel Echo + WebSockets -->
                                <script src="{{ asset('js/app.js') }}"></script>

                                <script>
                                    var map = L.map('map').setView([23.8103, 90.4125], 10);
                                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                                        maxZoom: 25
                                    }).addTo(map);

                                    let deliverymen = @json($deliverymen);
                                    let markers = {};

                                    deliverymen.forEach(dm => {
                                        if (dm.latitude && dm.longitude) {
                                            // Choose the CSS class based on active/inactive status
                                            const borderClass = dm.is_active ? 'animated-border-green' : 'animated-border-red';

                                            var icon = L.divIcon({
                                                className: 'custom-marker',
                                                html: `
                    <div style="text-align:center;">
                        <img src="${dm.image}"
                             class="${borderClass}"
                             style="width:40px;height:40px;border-radius:50%;margin-bottom:5px;" />
                        <img src="https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png"
                             style="width:25px;height:41px;" />
                    </div>
                `,
                                                iconSize: [40, 80],
                                                iconAnchor: [20, 80],
                                                popupAnchor: [0, -70]
                                            });

                                            let marker = L.marker([dm.latitude, dm.longitude], {
                                                icon
                                            }).addTo(map);
                                            marker.bindPopup(`<strong>${dm.name}</strong><br>Last Login: ${dm.first_login_at ?? 'N/A'}<br>Lat-Long: ${dm.latitude + ', ' + dm.longitude}`);
                                            markers[dm.id] = marker;
                                        }
                                    });
                                </script>



                                <br>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Delivery Man</th>
                                            <th>Last Active</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($deliveryman as $dm)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dm->name }}</td>
                                                <td>
                                                    @if ($dm->last_seen_at != null)

                                                    {{ \Carbon\Carbon::parse($dm->last_seen_at)->format('d-m-Y h:i A') }}</td>
                                                    @endif

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->

                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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

{{-- Map Options:
OpenStreetMap: https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
Carto Light: https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png
Carto Dark: https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png
Carto Positron: https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png
--}}
