"use strict";

var datatable;
var table;
// Class definition

function update_user_pwd() {
    var id = $('#user_acct_id').val();
    var mdp = $('#new_motdepasse').val();
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
            axios.post($(table).data('mdp-upd-url'), {id: id, mdp: mdp})
                    .then(response => {
                        KTApp.hidePageLoading();
                        switch (response.data.status) {
                            case 'success':
                                notify(lang.msg_save_succes, "success");
                                $('#btn_cancel').click();
                                break;
                            case 'fail':
                                notify(lang.msg_save_fail, "error");
                                notify(response.data.message, "info");
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
}

var KSpartenaireaccount = function () {
    // Define shared variables
    var userAccount = function () {
        // on click of add new menu
        $('#btn_new_user_account').click(function () {
            ks_load_modal($(this).data('url'), 'modal-lg', null, '1');
        });

        $('#btn_multiple_install').click(function () {
            const selectedItems = Array.from(table.querySelectorAll('tbody [type="checkbox"]:checked')).map(checkbox => checkbox.value);
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
                    axios.post($('#btn_multiple_install').data('url'), {id: selectedItems})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.ajax.reload();
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

        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
        });

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            info: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: $(table).data('url'),
                data: function (d) {
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
                    targets: [0, 4], // Index of the column to center (e.g., first column)
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
                {data: 'nomPrenoms', name: 'nomPrenoms'},
                {data: 'profile', name: 'profile'},
                {data: 'login', name: 'login'},
                {data: 'last_time_login', name: 'last_time_login'},
                {data: 'statut', name: 'statut'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init(); // reinit KTMenu instances
            handleEditUserAcct();
            handleDeleteUserAcct();
            handleStatusUserAcct();
            handleUserMdp();
        });
    };

    var handleUserMdp = () => {
        $('.user_acct_pwd').click(function () {
            ks_load_modal($(table).data('mdp-url'), 'modal-md', {id: $(this).data('id')}, '1');
        });
    };

    var handleStatusUserAcct = () => {
        $('.status_user_acct').click(function () {
            var id = $(this).data('id');
            var statut = $(this).data('statut');
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
                    axios.post($(table).data('statut-url'), {id: id, statut: statut})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.ajax.reload();
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

    var handleDeleteUserAcct = () => {
        $('.delete_user_acct').click(function () {
            var id = $(this).data('id');
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
                    axios.post($(table).data('delete-url'), {id: id})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.ajax.reload();
                                        break;
                                    case 'fail':
                                        notify(lang.msg_save_fail, "error");
                                        notify(response.data.message, "info");
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

    var handleEditUserAcct = () => {
        $('.edit_user_acct').click(function () {
            ks_load_modal($(table).data('edit-url'), 'modal-lg', {id: $(this).data('id')}, '1');
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_user_account');

            if (!table) {
                return;
            }
            userAccount();
            handleSearchDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSpartenaireaccount.init();
});
