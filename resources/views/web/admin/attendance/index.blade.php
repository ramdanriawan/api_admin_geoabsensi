@extends('web.admin.layouts.app')

@section("content")
    <div class="row">
        <h3>Attendance</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <style>
                            .btn:hover {
                                color: grey !important;
                            }
                        </style>
                        <li>
                            <a href="{{ url(route('web.admin.attendance.index', ['status' => 'present', 'date' => request('date')])) }}"
                               class="btn btn-xs btn-success {{ request('status') == 'present' ? 'disabled':'' }}"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Present</a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.attendance.index', ['status' => 'late', 'date' => request('date')])) }}"
                               class="btn btn-xs btn-warning {{ request('status') == 'late' ? 'disabled':'' }}"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Late</a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.attendance.index', ['status' => 'not present', 'date' => request('date')])) }}"
                               class="btn btn-xs btn-danger {{ request('status') == 'not present' ? 'disabled':'' }}"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Not
                                Present</a>
                        </li>

                        <li>
                            @php
                                use Carbon\Carbon;

                                $today = Carbon::today();
                            @endphp

                            <select name="date" id="date-select" class="form-control" required>
                                <option value="">-- Select Date --</option>
                                @for ($i = 0; $i < 30; $i++)
                                    @php
                                        $date = $today->copy()->subDays($i);
                                    @endphp
                                    <option
                                        {{ $date->format('Y-m-d') == request('date') ? "selected": "" }} value="{{ $date->format('Y-m-d') }}">
                                        {{ $date->translatedFormat('l, d F') }}
                                    </option>
                                @endfor
                            </select>

                        </li>

                        <li class="pull-right">
                            <button class="btn btn-default" onclick="exportToExcel('dataTable');">
                                <i class="fa fa-file-excel-o"></i>
                                Export
                            </button>

                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade padding in active" id="Active">
                            <table class="table " id="dataTable">

                                <thead>
                                <tr>
                                    <th width="auto">ID</th>
                                    <th width="auto">User Name</th>
                                    <th width="auto">Check In Time</th>
                                    <th width="auto">Check Out Time</th>
                                    <th width="auto">Total Hours</th>
                                    <th width="auto">Date</th>
                                    <th width="auto">Status</th>
                                    <th width="auto" data-exclude="true">Action</th>
                                </tr>
                                </thead>

                            </table>

                        </div>

                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@endsection

@section('script-in-this-page')
    <script>
        function redirectToAttendanceByDate(date) {
            const status = "{{ request('status') }}";
            const baseUrl = "{{ url(route('web.admin.attendance.index')) }}";

            // Buat URL lengkap
            const url = `${baseUrl}?status=${status}&date=${date}`;
            location.href = url;
        }

        // Contoh: panggil saat dropdown berubah
        $('#date-select').on('change', function () {
            const selectedDate = $(this).val();
            redirectToAttendanceByDate(selectedDate);
        });
    </script>

    <script type="text/javascript">
        $(function () {

            "use strict";

            // active
            let datatable1 = $('#dataTable').DataTable({
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                responsive: true,
                colReorder: true,
                "order": [[0, "asc"]],
                language: {
                    "emptyTable": "<div><br>You didn't make any transactions yet</div>",
                    search: "<i class='fa fa-search search-icon'></i>",
                    lengthMenu: '_MENU_ ',
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>'
                    }
                },
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url(route('api.v1.web.admin.attendance.dataTable')) }}',
                    data: {
                        'status': '{{ request('status') }}',
                        'date': '{{ request('date') }}'
                    }
                },
                pageLength: 10,
                sPaginationType: "full_numbers",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: true
                    }, {
                        data: 'user.name',
                        name: 'user name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'check_in_time',
                        name: 'check_in_time',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'check_out_time',
                        name: 'check_out_time',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'attendance_total_hours',
                        name: 'attendance_total_hours',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.delete-link', function (e) {
                e.preventDefault(); // cegah default link

                const deleteApiUrl = $(this).data('delete-api-url'); // ambil id dari data attribute

                if (confirm('Are u sure?')) {
                    $.ajax({
                        url: deleteApiUrl, // ganti dengan file backendmu
                        type: 'GET',
                        success: function (response) {

                            // response dari server, misal 'success' atau 'error'
                            if (response.success) {
                                alert('Success!');
                                // misal reload halaman atau hapus elemen dari DOM
                                datatable1.ajax.reload();
                            } else {
                                alert('Failed!');
                            }
                        },
                        error: function () {
                            alert('Error occured!');
                        }
                    });
                }
            });
        });
    </script>
@endsection
