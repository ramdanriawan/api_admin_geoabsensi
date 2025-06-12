@extends('web.admin.layouts.app')

@section("content")
    <div class="row">
        <h3>User</h3>
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
                            <a href="{{ url(route('web.admin.user.create')) }}" class="btn btn-xs btn-primary"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">+Add</a>
                        </li>
                        <li>
                            |
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.user.index', ['status' => 'active', 'level' => request('level')])) }}"
                               class="btn btn-xs btn-success"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Active</a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.user.index', ['status' => 'blocked', 'level' => request('level')])) }}"
                               class="btn btn-xs btn-danger"
                               style="margin-right: 10px; margin-left: 10px; color: white; display: inline-block;">Blocked</a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.user.index', ['status' => 'inactive', 'level' => request('level')])) }}"
                               class="btn btn-xs btn-default"
                               style="margin-right: 10px; margin-left: 10px;  display: inline-block;">Inactive</a>
                        </li>

                        <li>
                            |
                        </li>

                        <li>
                            <a href="{{ url(route('web.admin.user.index', ['status' => request('status'), 'level' => 'employee'])) }}"
                               class="btn btn-xs btn-default"
                               style="margin-right: 10px; margin-left: 10px; display: inline-block;">
                                <i class="fa fa-user"></i>

                                Employee
                            </a>
                        </li>
                        <li>
                            <a href="{{ url(route('web.admin.user.index', ['status' => request('status'), 'level' => 'admin'])) }}"
                               class="btn btn-xs btn-default"
                               style="margin-right: 10px; margin-left: 10px;  display: inline-block;">
                                <i class="fa fa-user"></i>
                                Admin
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade padding in active" id="Active">
                            <table class="table " id="dataTable">

                                <thead>
                                <tr>
                                    <th width="auto">ID</th>
                                    <th width="auto">Picture</th>
                                    <th width="auto">Name</th>
                                    <th width="auto">Username</th>
                                    <th width="auto">Email</th>
                                    <th width="auto">Level</th>
                                    <th width="auto">Status</th>
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
                    url: '{{ url(route('api.v1.web.admin.user.dataTable')) }}',
                    data: {
                        'status': '{{ request('status') }}',
                        'level': '{{ request('level') }}',
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
                    },{
                        data: 'profilePictureHtml',
                        name: 'picture',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'username',
                        name: 'username',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'level',
                        name: 'level',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
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
