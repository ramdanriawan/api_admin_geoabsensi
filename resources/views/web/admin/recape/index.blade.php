@extends('web.admin.layouts.app')

@section("content")
    <div class="row">
        <h3>Recape</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form>


                        <ul class="nav nav-tabs">
                            <style>
                                .btn:hover {
                                    color: grey !important;
                                }
                            </style>

                            <li>
                                <div class="form-group" style="margin-left: 10px;">
                                    <label>Start Date</label>
                                    <input id="startDate" type="date" name="start_date"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           value="{{ request('start_date', now()->addDays(-30)->toDateString()) }}"
                                           required>
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </li>

                            <li>
                                <div class="form-group" style="margin-left: 10px;">
                                    <label>End Date</label>
                                    <input id="endDate" type="date" name="end_date"
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           value="{{ request('end_date', now()->toDateString()) }}" required>
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </li>

                            <li>
                                <div class="form-group" style="margin-left: 10px;">
                                    <label></label>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>


                            </li>


                        <li class="pull-right">
                            <button class="btn btn-default" onclick="exportToExcel('dataTable');">
                                <i class="fa fa-file-excel-o"></i>
                                Export
                            </button>

                        </li>

                        </ul>
                    </form>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade padding in active" id="Active">
                            <table class="table " id="dataTable">

                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Present</th>
                                    <th>Late</th>
                                    <th>Absent</th>
                                    <th>Over Time Hours</th>
                                    <th>Sick</th>
                                    <th>Off Day</th>
                                    <th>Trip</th>
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
        function redirectToRecapeByDate(date) {
            const baseUrl = "{{ url(route('web.admin.recape.index')) }}";

            // Buat URL lengkap
            const url = `${baseUrl}?date=${date}`;
            location.href = url;
        }

        // Contoh: panggil saat dropdown berubah
        $('#date-select').on('change', function () {
            const selectedDate = $(this).val();
            redirectToRecapeByDate(selectedDate);
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
                    emptyTable: "<div><br>No recape data available</div>",
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
                    url: '{{ url(route('api.v1.web.admin.recape.dataTable')) }}',
                    data: {
                        start_date: '{{ request('start_date') }}',
                        end_date: '{{ request('end_date') }}'
                    }
                },
                pageLength: 10,
                sPaginationType: "full_numbers",
                columns: [
                    {data: 'user.name', name: 'user.name', orderable: false, searchable: true},
                    {data: 'present', name: 'present', orderable: true, searchable: true},
                    {data: 'late', name: 'late', orderable: true, searchable: true},
                    {data: 'absent', name: 'absent', orderable: true, searchable: false},
                    {data: 'overTimeHours', name: 'overTimeHours', orderable: true, searchable: false},
                    {data: 'sick', name: 'sick', orderable: true, searchable: false},
                    {data: 'offDay', name: 'offDay', orderable: true, searchable: false},
                    {data: 'trip', name: 'trip', orderable: true, searchable: false},
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
