@extends('web.admin.layouts.app')

@section("content")
    <div class="row">
        <h3>Pay Slip</h3>
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
                            <a href="{{ url(route('web.admin.paySlip.create')) }}" class="btn btn-xs btn-primary"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">+Add</a>
                        </li>

                        <li> |</li>


                        <li>
                            <a href="{{ url(route('web.admin.paySlip.index', ['status' => 'agreed', 'date' => request('date')])) }}"
                               class="btn btn-xs btn-success {{ request('status') == 'agreed' ? 'disabled':'' }}"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Agreed</a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.paySlip.index', ['status' => 'disagreed', 'date' => request('date')])) }}"
                               class="btn btn-xs btn-danger {{ request('status') == 'disagreed' ? 'disabled':'' }}"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Disagreed</a>
                        </li>

                        <li> |</li>


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
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Period Start</th>
                                    <th>Period End</th>
                                    <th>Basic Salary</th>
                                    <th>Bonus</th>
                                    <th>Total Earnings</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th data-exclude="true">Action</th>
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
        function redirectToPaySlipByDate(date) {
            const baseUrl = "{{ url(route('web.admin.paySlip.index')) }}";

            // Buat URL lengkap
            const url = `${baseUrl}?date=${date}&status={{ request('status') }}`;
            location.href = url;
        }

        // Contoh: panggil saat dropdown berubah
        $('#date-select').on('change', function () {
            const selectedDate = $(this).val();
            redirectToPaySlipByDate(selectedDate);
        });
    </script>

    <script type="text/javascript">
        $(function () {

            "use strict";

            // active
            let datatable1 = $('#dataTable').DataTable({
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                responsive: true,
                colReorder: true,
                order: [[0, "asc"]],
                language: {
                    emptyTable: "<div><br>No paySlip data available</div>",
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
                    url: '{{ url(route('api.v1.web.admin.paySlip.dataTable')) }}',
                    data: {
                        status: '{{ request('status') }}',
                        date: '{{ request('date') }}'
                    }
                },
                pageLength: 10,
                sPaginationType: "full_numbers",
                columns: [
                    {data: 'id', name: 'id', orderable: true, searchable: true},
                    {data: 'user.name', name: 'user.name', orderable: false, searchable: true},
                    {
                        data: 'periodStartDateTime.day_date_month_human',
                        name: 'period_start',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'periodStartDateTime.day_date_month_human',
                        name: 'period_end',
                        orderable: true,
                        searchable: true
                    },
                    {data: 'basicSalaryString', name: 'basic_salary', orderable: true, searchable: false},
                    {data: 'bonusString', name: 'bonus', orderable: true, searchable: false},
                    {data: 'netSalaryString', name: 'net_salary', orderable: true, searchable: false},
                    {

                        data: 'statusHtml',
                        name: 'status', orderable: true, searchable: false
                    }, {

                        data: 'dateDateTime.day_date_month_human',
                        name: 'date', orderable: true, searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
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
