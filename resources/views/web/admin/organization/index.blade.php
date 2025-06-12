@extends('web.admin.layouts.app')

@section("content")
    <div class="row">
        <h3>Organization</h3>
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
                            <a href="{{ url(route('web.admin.organization.create')) }}" class="btn btn-xs btn-primary"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">+Add</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade padding in active" id="Active">
                            <table class="table " id="dataTable">

                                <thead>
                                <tr>
                                    <th width="auto">ID</th>
                                    <th width="auto">Name</th>
                                    <th width="auto">Logo</th>
                                    <th width="auto">Description</th>
                                    <th width="auto">Lat</th>
                                    <th width="auto">Lng</th>
                                    <th width="auto">Is Active</th>
{{--                                    <th width="auto">Created At</th>--}}
                                    <th width="auto">Action</th>
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
                    url: '{{ url(route('api.v1.web.admin.organization.dataTable')) }}',
                },
                pageLength: 10,
                sPaginationType: "full_numbers",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'logoHtml',
                        name: 'logo',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'lat',
                        name: 'lat',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'lng',
                        name: 'lng',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'createdAtDateTime.day_date_month_human',
                    //     name: 'created_at',
                    //     orderable: true,
                    //     searchable: true
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
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
