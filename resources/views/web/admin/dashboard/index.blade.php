@extends('web.admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-users fa-2x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="total-transaksi-bulan-ini">{{ $employeeCount }}</div>
                            <div>Employee</div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)">

                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-check-circle fa-2x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="total-transaksi-minggu-ini">{{ $attendanceCount }}</div>
                            <div>Attendance</div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)">

                </a></div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-clock-o fa-2x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="total-transaksi-hari-ini">{{ $overTimeCount }}</div>
                            <div>Over Time</div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)">

                </a></div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-umbrella fa-2x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="total-transaksi-hari-ini">{{ $offDayCount }}</div>
                            <div>Off Day</div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)">

                </a></div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Attendance Today
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Shift</th>
                            <th>Check In Time</th>
                            <th>Status</th>
                            <th>Location</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($todayAttendances as $attendance)
                            <tr>
                                <td>{{ $attendance->user->name }}</td>
                                <td>{{ $attendance->user->user_shift?->shift->name }}</td>
                                <td>{{ $attendance->check_in_time }}</td>
                                <td>
                                <span class="label
                                    @if($attendance->status === 'present') label-success
                                    @elseif($attendance->status === 'late') label-warning
                                    @else label-danger
                                    @endif">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                                </td>
                                <td>{{ $attendance->lat }}, {{ $attendance->lng }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Weekly Attendance Summary</div>
                <div class="panel-body">
                    <div id="weekly-attendance-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Organization Map</div>
                <div class="panel-body">
                    @php
                        $lat = $mapCenterLat;
                        $lng = $mapCenterLng;
                    @endphp

                    @if($lat && $lng)
                        <iframe
                            width="100%"
                            height="215"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=16&output=embed">
                        </iframe>
                    @else
                        <p>Location not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script-in-this-page')
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <script>

        new Morris.Bar({
            element: 'weekly-attendance-chart',
            data: @json($weeklyAttendanceChartData),
            xkey: 'day',
            ykeys: ['present', 'late', 'not_present'],
            labels: ['Present', 'Late', 'Absent'],
            barColors: ['#00a65a', '#f39c12', '#dd4b39'],
            hideHover: 'auto',
            resize: true
        });
    </script>
@endsection

