@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <h3>Show</h3>

                    @if(session()->has('success'))
                        @if(!session()->get('success'))
                            <strong style="color: red;">{{ session()->get('message') }}</strong>
                        @endif
                    @endif

                    <!-- Tab panes -->
                    <!-- Tab panes -->
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{ $trip->id }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $trip->employee->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Trip Type</th>
                            <td>{{ $trip->trip_type->name }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $trip->startDateDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $trip->endDateDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $trip->dateDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Total Hours</th>
                            <td>{{ $trip->duration_in_hours }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $status = $trip->status;

                                    switch ($status) {
                                        case 'agreed':
                                            $label = 'success';
                                            $text = 'Aggreed';
                                            break;
                                        case 'waiting':
                                            $label = 'warning';
                                            $text = 'Waiting';
                                            break;
                                        case 'disagreed':
                                            $label = 'danger';
                                            $text = 'Disagreed';
                                            break;
                                        default:
                                            $label = 'default';
                                            $text = ucfirst($status);
                                    }
                                @endphp

                                <span class="label label-{{ $label }}">{{ $text }}</span>

                            </td>
                        </tr>

                    </table>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Nav tabs -->
                <h3>Detail</h3>

                    @if(session()->has('success'))
                        @if(!session()->get('success'))
                            <strong style="color: red;">{{ session()->get('message') }}</strong>
                        @endif
                    @endif

                    <!-- Tab panes -->
                    <!-- Tab panes -->
                    <table class="table table-bordered">
                        <tr>
                            <th>Picture</th>
                            <td>
                                @if($trip->trip_attendance->picture)
                                    <img src="{{ $trip->trip_attendance->pictureUrl }}" alt="Check In"
                                         width="100">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Latitude</th>
                            <td>{{ $trip->trip_attendance->lat }}</td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td>{{ $trip->trip_attendance->lng }}</td>
                        </tr>
                        <tr>
                            <th>Distance (Check In)</th>
                            <td>{{ $trip->trip_attendance->distance_in_kilometers }} m</td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $trip->trip_attendance->createdAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $trip->trip_attendance->updatedAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Map</th>
                            <th>
                                @php
                                    $lat = $trip->trip_attendance->lat;
                                    $lng = $trip->trip_attendance->lng;
                                @endphp

                                @if($lat && $lng)
                                    <iframe
                                        width="100%"
                                        height="300"
                                        style="border:0"
                                        loading="lazy"
                                        allowfullscreen
                                        src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=16&output=embed">
                                    </iframe>
                                @else
                                    <p>Location not available</p>
                                @endif
                            </th>
                        </tr>

                    </table>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@endsection

