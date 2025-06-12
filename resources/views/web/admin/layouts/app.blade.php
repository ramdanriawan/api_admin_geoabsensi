<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('') }}/templateadmin1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ url('') }}/templateadmin1/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- jvectormap CSS -->
    <link href="{{ url('') }}/templateadmin1/vendor/jquery-jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('') }}/templateadmin1/css/adminnine.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('') }}/templateadmin1/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">


</head>

<body>
<!-- loader -->
<!-- loader ends -->
<div id="wrapper">
    @include('web.admin.layouts.navbar')

    <!-- /.navbar-static-side -->
    <div id="page-wrapper">
        <div class="row">
            <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
            </nav>
        </div>

        <!-- /.row -->

        <ol class="breadcrumb">

        </ol>

        <style>
            .custom-toast {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1050;
                min-width: 250px;
                max-width: 300px;
                padding: 15px;
                border-radius: 4px;
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .custom-toast.show {
                opacity: 1;
            }
        </style>

        @if (session('success'))
            <div id="toast-success" class="custom-toast alert alert-success">
                <span class="glyphicon glyphicon-ok-sign" style="margin-right: 20px;"></span>
                Success
            </div>
        @endif

        @if ($errors->first())
            <div id="toast-error" class="custom-toast alert alert-danger">
                <i class="fa fa-times-circle" style="margin-right: 20px;"></i>
                Error
            </div>
        @endif

        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
{{--<script src="{{ url('') }}/templateadmin1/vendor/jquery/jquery.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


<!-- Bootstrap Core JavaScript -->
<script src="{{ url('') }}/templateadmin1/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- DataTables JavaScript -->
<script src="{{ url('') }}/templateadmin1/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/templateadmin1/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="{{ url('') }}/templateadmin1/vendor/datatables-responsive/dataTables.responsive.js"></script>


<!-- jvectormap JavaScript -->
<script src="{{ url('') }}/templateadmin1/vendor/jquery-jvectormap/jquery-jvectormap.js"></script>
<script src="{{ url('') }}/templateadmin1/vendor/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ url('') }}/templateadmin1/js/adminnine.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


<style>
    .cke_notification.cke_notification_warning {
        display: none;
    }
</style>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

{{-- flatpickr --}}
<script src="//cdn.jsdelivr.net/npm/flatpickr"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        var $toast = $('#toast-success');
        if ($toast.length) {
            $toast.addClass('show');
            setTimeout(function () {
                $toast.removeClass('show').fadeOut('slow');
            }, 2000); // 2 detik
        }
    });
</script>

<script>
    $(document).ready(function () {
        var $toastError = $('#toast-error');
        if ($toastError.length) {
            $toastError.addClass('show');
            setTimeout(function () {
                $toastError.removeClass('show').fadeOut('slow');
            }, 2000); // 2 detik
        }
    });
</script>

<script>
    // ini harus dibuat supaya ck editor bisa upload gambar
    CKEDITOR.config.filebrowserUploadMethod = 'form';

    // ini adalah inisialisasi setiap ck editor, dari id 0 sampai 3, jadi kalo perlu ckeditornya
    // kita tinggal pasang aja id yang tersedia dibawah ini, dan ck editor pun langsung tampil
    if (document.querySelector('#editor-0')) {
        CKEDITOR.replace('editor-0', {
            height: 200,
            filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
        });
    }

    if (document.querySelector('#editor0')) {
        CKEDITOR.replace('editor0', {
            height: 200,
            filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
        });
    }

    if (document.querySelector('#editor-1')) {
        CKEDITOR.replace('editor-1', {
            height: 200,
            filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
        });
    }

    if (document.querySelector('#editor1')) {
        CKEDITOR.replace('editor1', {
            height: 200,
            filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
        });
    }
</script>

<style>
    .select2-container {
        box-sizing: border-box;
        display: inline-block;
        margin: 0;
        position: relative;
        vertical-align: middle;
        width: 100% !important;
    }
</style>

<script>
    function exportToExcel(tableIdSelector) {
        const table = document.getElementById(tableIdSelector);
        const rows = [];
        const excludeIndexes = [];

        // Cari kolom yang mau di-exclude (berdasarkan data-exclude)
        const ths = table.querySelectorAll("thead th");
        ths.forEach((th, index) => {
            if (th.getAttribute("data-exclude") === "true") {
                excludeIndexes.push(index);
            }
        });

        // Loop semua baris di tabel
        for (let r = 0; r < table.rows.length; r++) {
            const row = table.rows[r];
            const cols = [];

            for (let c = 0; c < row.cells.length; c++) {
                if (!excludeIndexes.includes(c)) {
                    const cell = row.cells[c];

                    // Kalau ada select, ambil opsi yang dipilih
                    const select = cell.querySelector('select');
                    if (select) {
                        const selectedText = select.options[select.selectedIndex]?.text || '';
                        cols.push(selectedText.trim());
                    } else {
                        // Kalau tidak ada select, ambil innerText biasa
                        const clone = cell.cloneNode(true);
                        clone.querySelectorAll('button, svg, i, .dropdown, .status-dropdown').forEach(el => el.remove());
                        const text = clone.innerText || clone.textContent || "";
                        cols.push(text.trim());
                    }
                }
            }

            rows.push(cols.join('\t'));
        }

        const excelContent = rows.join('\n');
        const blob = new Blob([excelContent], {type: 'application/vnd.ms-excel'});
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = 'export.xls';
        a.click();

        URL.revokeObjectURL(url);
    }
</script>


@yield('script-in-this-page')

</body>
</html>
