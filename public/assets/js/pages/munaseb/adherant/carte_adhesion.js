"use strict";

var datatable;
var table;
// Class definition

var KSAdherant = function () {

    var handleCarte = () => {
        $('.print_row').click(function () {
            ks_load_modal($(table).data('print-url'), 'modal-xl', {
                id: $(this).data('id')
            }, '1');
        });
    };
    
    $('.verso_print').click(function () {
        ks_load_modal($(this).data('url'), 'modal-xl', {}, '1');
    });

    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });

    $('#adherant_import').change(function () {
        KTApp.showPageLoading();
        $('#frm_adherant_import').submit();
    });

    $('.btn_new').click(function () {
        ks_load_view($(this).data('url'));
    });
    
    $('.btn_signateur').click(function () {
        ks_load_view($(this).data('url'));
    });

    var handleDT = function () {
        datatable = $(table).DataTable({
            responsive: true,
            info: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: $(table).data('url'),
                data: function (d) {
                    var formData = $('#koriss_left_drawer_frm').serializeArray(); // Get form data
                    $.each(formData, function (key, value) {
                        d[value.name] = value.value; // Append form fields to AJAX data
                    });

                    d.column = d.order[0].column; // Column index
                    d.dir = d.order[0].dir; // Sort direction
                    d.search = d.search.value; // Search value
                    d.length = d.length; // Length
                    d.start = d.start; // Start
                }
            },
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: [0, 9], // Index of the column to center (e.g., first column)
                    className: 'text-center'
                }
            ],
            columns: [
                {
                    data: null,
                    name: 'order_number',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'codeAdherant', name: 'codeAdherant'},
                {data: 'ine', name: 'ine'},
                {data: 'nom', name: 'nom'},
                {data: 'prenoms', name: 'prenoms'},
                {data: 'tel', name: 'tel'},
                {data: 'email', name: 'email'},
                {data: 'solde', name: 'solde'},
                {data: 'periode', name: 'periode'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleCarte();
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-adherant-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };

    $(document).on('click', '.action_circuit', function () {
        const id = $(this).data('id');
        const url = $(table).data('circuit-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    $(document).on('click', '.edit_row', function () {
        const id = $(this).data('id');
        const url = $(this).data('edit-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    $(document).on('click', '.consult_row', function () {
        const id = $(this).data('id');
        const url = $(this).data('consult-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    var handleStatut = (m) => {
        $(document).on('click', '.status_row', function () {
            var id = $(this).data('id');
            var statut = $(this).data('statut');
            var url = $(this).data('statuts-url');
            Swal.fire({
                title: lang.msg_toconfirm,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: lang.msg_confirm,
                cancelButtonText: lang.msg_cancel,
                closeOnConfirm: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    KTApp.showPageLoading();
                    axios.post(url, {id: id, statut: statut})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.draw();
                                        break;
                                    case 'fail':
                                        notify(lang.msg_save_fail, "error");
                                        break;
                                    default:
                                        notify(lang.msg_save_fail, "error");
                                        break;
                                }
                            })
                            .catch(error => {
                                notify(error, "error");
                                KTApp.hidePageLoading();
                            });
                }
            });
        });
    };


    $(document).on('click', '.delete_row', function () {
        var id = $(this).data('id');
        var url = $(table).data('delete-url');
        Swal.fire({
            title: lang.msg_toconfirm,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: lang.msg_confirm,
            cancelButtonText: lang.msg_cancel,
            closeOnConfirm: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-secondary"
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                KTApp.showPageLoading();
                axios.post(url, {id: id})
                        .then(response => {
                            KTApp.hidePageLoading();
                            switch (response.data.status) {
                                case 'success':
                                    notify(lang.msg_save_succes, "success");
                                    datatable.draw();
                                    break;
                                case 'fail':
                                    notify(lang.msg_save_fail, "error");
                                    break;
                                default:
                                    notify(lang.msg_save_fail, "error");
                                    break;
                            }
                        })
                        .catch(error => {
                            notify(error, "error");
                            KTApp.hidePageLoading();
                        });
            }
        });
    });

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_adherant');
            handleDT();
            handleSearchDatatable();
            handleStatut('.status');
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSAdherant.init();
});
