$(function () {
    /*
    * ini untuk perhitungan total transaksi
    */
    totalTransaksiBulanIni = 0;
    totalTransaksiMingguIni = 0;
    totalTransaksiHariIni = 0;

    totalPendapatanHariIni = 0;
    totalPendapatanBulanIni = 0;
    jumlahOrderHariIni = 0;
    jumlahOrderBulanIni = 0;
    jumlahPendaftaranHariIni = 0;
    jumlahPendaftaranBulanIni = 0;

    function writeTotalToHtmlElementTotalTransaksi(response) {
        totalTransaksiBulanIni += response.bulan_ini_angka;
        totalTransaksiMingguIni += response.minggu_ini_angka;
        totalTransaksiHariIni += response.hari_ini_angka;

        totalPendapatanHariIni += response.hari_ini_angka;
        totalPendapatanBulanIni += response.bulan_ini_angka;
        jumlahOrderHariIni += response.hari_ini_jumlah_order;
        jumlahOrderBulanIni += response.bulan_ini_jumlah_order;
        jumlahPendaftaranHariIni += response.hari_ini_jumlah_pendaftaran;
        jumlahPendaftaranBulanIni += response.bulan_ini_jumlah_pendaftaran;

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                maximumFractionDigits: 0
            }).format(number);
        }


        $('#total-transaksi-bulan-ini').text(rupiah(totalTransaksiBulanIni).replace("Rp", ""));
        $('#total-transaksi-minggu-ini').text(rupiah(totalTransaksiMingguIni).replace("Rp", ""));
        $('#total-transaksi-hari-ini').text(rupiah(totalTransaksiHariIni).replace("Rp", ""));

        $('#total-pendapatan-hari-ini').text(rupiah(totalPendapatanHariIni).replace("Rp", ""));
        $('#total-pendapatan-bulan-ini').text(rupiah(totalPendapatanBulanIni).replace("Rp", ""));
        $('#jumlah-order-hari-ini').text(rupiah(jumlahOrderHariIni).replace("Rp", ""));
        $('#jumlah-order-bulan-ini').text(rupiah(jumlahOrderBulanIni).replace("Rp", ""));
        $('#jumlah-pendaftaran-hari-ini').text(rupiah(jumlahPendaftaranHariIni).replace("Rp", ""));
        $('#jumlah-pendaftaran-bulan-ini').text(rupiah(jumlahPendaftaranBulanIni).replace("Rp", ""));

        $('#persentase-pendapatan-bulan-ini-100').text(rupiah(totalTransaksiBulanIni));
        $('#persentase-pendapatan-bulan-ini-90').text(rupiah(totalTransaksiBulanIni * 0.90));
        $('#persentase-pendapatan-bulan-ini-10').text(rupiah(totalTransaksiBulanIni * 0.10));
    }

    function writeTotalToHtmlElementTotalPendapatanDanOrderDanUser(response, idColPendapatanHariIni, idColOrderHariIni, idColPendaftaranHariIni, idColPendapatanBulanIni, idColOrderBulanIni, idColPendaftaranBulanIni) {
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                maximumFractionDigits: 0
            }).format(number);
        }

        $(`${idColPendapatanHariIni}`).text(rupiah(response.hari_ini_angka).replace("Rp", ""));
        $(`${idColOrderHariIni}`).text(rupiah(response.hari_ini_jumlah_order).replace("Rp", ""));
        $(`${idColPendaftaranHariIni}`).text(rupiah(response.hari_ini_jumlah_pendaftaran).replace("Rp", ""));

        $(`${idColPendapatanBulanIni}`).text(rupiah(response.bulan_ini_angka).replace("Rp", ""));
        $(`${idColOrderBulanIni}`).text(rupiah(response.bulan_ini_jumlah_order).replace("Rp", ""));
        $(`${idColPendaftaranBulanIni}`).text(rupiah(response.bulan_ini_jumlah_pendaftaran).replace("Rp", ""));
    }

    function getTotalTransaksiUsingAjaxGet(url, idColPendapatanHariIni, idColOrderHariIni, idColPendaftaranHariIni, idColPendapatanBulanIni, idColOrderBulanIni, idColPendaftaranBulanIni) {
        $.ajax({
            'url': url,
            success: function (response) {
                writeTotalToHtmlElementTotalTransaksi(response);
                writeTotalToHtmlElementTotalPendapatanDanOrderDanUser(response, idColPendapatanHariIni, idColOrderHariIni, idColPendaftaranHariIni, idColPendapatanBulanIni, idColOrderBulanIni, idColPendaftaranBulanIni);
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });
    }

    // untuk mendapatkan total transaksi
    getTotalTransaksiUsingAjaxGet(
        "https://www.aicloud.id/weblabtik/admin/finance/transaction/listTransactionTotal",
        '#pendapatan_hari_ini_aicloud',
        '#order_hari_ini_aicloud',
        '#pendaftaran_hari_ini_aicloud',
        '#pendapatan_bulan_ini_aicloud',
        '#order_bulan_ini_aicloud',
        '#pendaftaran_bulan_ini_aicloud',
    );

    getTotalTransaksiUsingAjaxGet(
        "https://app.autokonten.com/weblabtik/transactions/listTransactionTotal",
        '#pendapatan_hari_ini_autokonten',
        '#order_hari_ini_autokonten',
        '#pendaftaran_hari_ini_autokonten',
        '#pendapatan_bulan_ini_autokonten',
        '#order_bulan_ini_autokonten',
        '#pendaftaran_bulan_ini_autokonten',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://app.cekserp.com/weblabtik/transactions/listTransactionTotal",
        '#pendapatan_hari_ini_cekserp',
        '#order_hari_ini_cekserp',
        '#pendaftaran_hari_ini_cekserp',
        '#pendapatan_bulan_ini_cekserp',
        '#order_bulan_ini_cekserp',
        '#pendaftaran_bulan_ini_cekserp',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://www.dataseo.co.id/weblabtik/invoice/listTransactionTotal",
        '#pendapatan_hari_ini_dataseo',
        '#order_hari_ini_dataseo',
        '#pendaftaran_hari_ini_dataseo',
        '#pendapatan_bulan_ini_dataseo',
        '#order_bulan_ini_dataseo',
        '#pendaftaran_bulan_ini_dataseo',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://app.index.or.id/weblabtik/invoice/listTransactionTotal",
        '#pendapatan_hari_ini_index',
        '#order_hari_ini_index',
        '#pendaftaran_hari_ini_index',
        '#pendapatan_bulan_ini_index',
        '#order_bulan_ini_index',
        '#pendaftaran_bulan_ini_index',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://app.jasatraffic.com/weblabtik/transactions/listTransactionTotal",
        '#pendapatan_hari_ini_jasatraffic',
        '#order_hari_ini_jasatraffic',
        '#pendaftaran_hari_ini_jasatraffic',
        '#pendapatan_bulan_ini_jasatraffic',
        '#order_bulan_ini_jasatraffic',
        '#pendaftaran_bulan_ini_jasatraffic',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://www.php.id/weblabtik/users/listTransactionTotal",
        '#pendapatan_hari_ini_phpid',
        '#order_hari_ini_phpid',
        '#pendaftaran_hari_ini_phpid',
        '#pendapatan_bulan_ini_phpid',
        '#order_bulan_ini_phpid',
        '#pendaftaran_bulan_ini_phpid',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://www.labtik.com/data/data/weblabtik/pondoksoft/listTransactionTotal",
        '#pendapatan_hari_ini_scodepro',
        '#order_hari_ini_scodepro',
        '#pendaftaran_hari_ini_scodepro',
        '#pendapatan_bulan_ini_scodepro',
        '#order_bulan_ini_scodepro',
        '#pendaftaran_bulan_ini_scodepro',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://app.spinartikel.com/weblabtik/invoice/listTransactionTotal",
        '#pendapatan_hari_ini_spinartikel',
        '#order_hari_ini_spinartikel',
        '#pendaftaran_hari_ini_spinartikel',
        '#pendapatan_bulan_ini_spinartikel',
        '#order_bulan_ini_spinartikel',
        '#pendaftaran_bulan_ini_spinartikel',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://panel.watsap.id/weblabtik/api/order/listTransactionTotal",
        '#pendapatan_hari_ini_watsap',
        '#order_hari_ini_watsap',
        '#pendaftaran_hari_ini_watsap',
        '#pendapatan_bulan_ini_watsap',
        '#order_bulan_ini_watsap',
        '#pendaftaran_bulan_ini_watsap',
    );
    getTotalTransaksiUsingAjaxGet(
        "https://app.zender.id/weblabtik/admin/plan/order/listTransactionTotal",
        '#pendapatan_hari_ini_zender',
        '#order_hari_ini_zender',
        '#pendaftaran_hari_ini_zender',
        '#pendapatan_bulan_ini_zender',
        '#order_bulan_ini_zender',
        '#pendaftaran_bulan_ini_zender',
    );

    /*
   * ini untuk table transaksi yang sedang ditransfer tapi belum dikonfirmasi
   */
    data = [];
    no = 0;

    var datatablesPaymentTable = $('#dataTables-payment-table').DataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        responsive: true,
        colReorder: true,
        "order": [[3, "desc"]],
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
        serverSide: false,
        pageLength: 10,
        sPaginationType: "full_numbers",
        data: data,
        columns: [
            {
                data: 'no',
                orderable: true,
                searchable: false
            },
            {
                data: 'email',
                orderable: true,
                searchable: true
            },
            {
                data: 'website',
                orderable: true,
                searchable: true
            },
            {
                data: 'tanggal',
                orderable: true,
                searchable: true
            },
            {
                data: 'actions',
                orderable: true,
                searchable: true
            },
        ]
    });

    function getAllTabelTransaksiSudahTransferUsingAjaxGetOrPost() {
        $.ajax({
            'url': "https://www.aicloud.id/weblabtik/admin/finance/transactions?status=PendingPayment",
            'method': "GET",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.email,
                        website: 'aicloud.id',
                        tanggal: item.created_at,
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();

            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });



        $.ajax({
            'url': "https://app.autokonten.com/weblabtik/transactions?status=payment",
            'method': "GET",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.user_email,
                        website: 'autokonten.com',
                        tanggal: item['created-on'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        $.ajax({
            'url': "https://app.cekserp.com/weblabtik/transactions?status=payment",
            'method': "GET",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.user_email,
                        website: 'app.cekserp.com',
                        tanggal: item['created-on'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        $.ajax({
            'url': "https://www.dataseo.co.id/weblabtik/invoice/list_data/0tf",
            'method': "GET",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.username,
                        website: 'www.dataseo.co.id',
                        tanggal: item['tgl_order'],
                        actions: item.action
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });


        $.ajax({
            'url': "https://app.index.or.id/weblabtik/invoice/list_data/0tf",
            'method': "POST",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.username,
                        website: 'app.index.or.id',
                        tanggal: item['tgl_order'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        $.ajax({
            'url': "https://app.jasatraffic.com/weblabtik/transactions?status=payment",
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.user_email,
                        website: 'app.jasatraffic.com',
                        tanggal: item['created_at'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        // $.ajax({
        //     'url': "https://www.php.id/weblabtik/users",
        //     success: function (response) {
        //         $.each(response.data, (index, item) => {
        //
        //             datatablesPaymentTable.row.add({
        //                 no: ++no,
        //                 email: item.email,
        //                 website: 'www.php.id',
        //                 tanggal: item['tgl_input'],
        //                 actions: item.actions
        //             });
        //         })
        //
        //         datatablesPaymentTable.order([0, 'asc']).draw();
        //     },
        //     error: function (err) {
        //         console.log(err)
        //         alert(err)
        //     }
        // });

        // $.ajax({
        //     'url': "https://www.labtik.com/data/data/weblabtik/pondoksoft/get_user",
        //     method: 'POST',
        //     success: function (response) {
        //         $.each(response.data, (index, item) => {
        //
        //             datatablesPaymentTable.row.add({
        //                 no: ++no,
        //                 email: item.nama,
        //                 website: 'Scodepro',
        //                 tanggal: item['tgl'],
        //                 actions: item.actions
        //             });
        //         })
        //
        //         datatablesPaymentTable.order([0, 'asc']).draw();
        //     },
        //     error: function (err) {
        //         console.log(err)
        //         alert(err)
        //     }
        // });

        $.ajax({
            'url': "https://app.spinartikel.com/weblabtik/invoice/list_data/0tf",
            method: 'GET',
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.username,
                        website: 'app.spinartikel.com',
                        tanggal: item['tgl_order'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        $.ajax({
            'url': "https://panel.watsap.id/weblabtik/api/order/get/0tf?draw=1&columns%5B0%5D%5Bdata%5D=no&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=no_order&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=judul&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=harganya&columns%5B3%5D%5Bname%5D=harga&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=tgl_input&columns%5B4%5D%5Bname%5D=tgl_order&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=action&columns%5B5%5D%5Bname%5D=action&columns%5B5%5D%5Bsearchable%5D=false&columns%5B5%5D%5Borderable%5D=false&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&start=0&length=1000&search%5Bvalue%5D=&search%5Bregex%5D=false&_=1703915319819",
            method: 'GET',
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.email,
                        website: 'watsap.id',
                        tanggal: item['tgl_input'],
                        actions: item.action
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });

        $.ajax({
            'url': "https://app.zender.id/weblabtik/admin/plan/order?status=hold",
            method: 'GET',
            success: function (response) {
                $.each(response.data, (index, item) => {

                    datatablesPaymentTable.row.add({
                        no: ++no,
                        email: item.email,
                        website: 'app.zender.id',
                        tanggal: item['created_at'],
                        actions: item.actions
                    });
                })

                datatablesPaymentTable.order([0, 'asc']).draw();
            },
            error: function (err) {
                console.log(err)
                alert(err)
            }
        });
    }

    getAllTabelTransaksiSudahTransferUsingAjaxGetOrPost();

});
