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
                            <td>{{ $attendance->id }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $attendance->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Check In Time</th>
                            <td>{{ $attendance->check_in_time }}</td>
                        </tr>
                        <tr>
                            <th>Check Out Time</th>
                            <td>{{ $attendance->check_out_time }}</td>
                        </tr>
                        <tr>
                            <th>Total Hours</th>
                            <td>{{ $attendance->attendance_total_hours }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $attendance->dateDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $status = $attendance->status;

                                    switch ($status) {
                                        case 'present':
                                            $label = 'success';
                                            $text = 'Present';
                                            break;
                                        case 'late':
                                            $label = 'warning';
                                            $text = 'Late';
                                            break;
                                        case 'not present':
                                            $label = 'danger';
                                            $text = 'Not Present';
                                            break;
                                        default:
                                            $label = 'default';
                                            $text = ucfirst($status);
                                    }
                                @endphp

                                <span class="label label-{{ $label }}">{{ $text }}</span>

                            </td>
                        </tr>
                        <tr>
                            <th>Picture</th>
                            <td>
                                @if($attendance->picture)
                                    <img src="{{ $attendance->pictureUrl }}" alt="Check In"
                                         width="100">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Picture Check Out</th>
                            <td>
                                @if($attendance->picture_check_out)
                                    <img src="{{ $attendance->pictureCheckOutUrl }}" alt="Check Out"
                                         width="100">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Latitude</th>
                            <td>{{ $attendance->lat }}</td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td>{{ $attendance->lng }}</td>
                        </tr>
                        <tr>
                            <th>Distance (Check In)</th>
                            <td>{{ $attendance->distance_in_meters }} m</td>
                        </tr>
                        <tr>
                            <th>Distance (Check Out)</th>
                            <td>{{ $attendance->distance_in_meters_check_out }} m</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $attendance->createdAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $attendance->updatedAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Map</th>
                            <th>
                                @php
                                    $lat = $attendance->lat;
                                    $lng = $attendance->lng;
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

