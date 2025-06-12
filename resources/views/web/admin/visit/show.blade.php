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
                            <td>{{ $visit->id }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{ $visit->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Check In Time</th>
                            <td>{{ $visit->check_in_time }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $visit->dateDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $status = $visit->status;

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
                                @if($visit->picture)
                                    <img src="{{ $visit->pictureUrl }}" alt="Check In"
                                         width="100">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Latitude</th>
                            <td>{{ $visit->lat }}</td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td>{{ $visit->lng }}</td>
                        </tr>
                        <tr>
                            <th>Distance (Check In)</th>
                            <td>{{ $visit->distance_in_kilometers }} m</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $visit->createdAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $visit->updatedAtDateTime['day_date_month_year_human'] }}</td>
                        </tr>
                        <tr>
                            <th>Map</th>
                            <th>
                                @php
                                    $lat = $visit->lat;
                                    $lng = $visit->lng;
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

