"use strict";

var datatable;
// Class definition
var KSMenu = function () {
    // Define shared variables
    var table;

    var sysMenu = function () {
        $('#ck_all').click(function () {
            if ($('#ck_all').is(':checked')) {
                $(table).find('.form-check-input').prop('checked', true);
            } else {
                $(table).find('.form-check-input').prop('checked', false);
            }
        });

        // on click of add new menu
        $('#btn_new_menu').click(function () {
            ks_load_modal($(this).data('url'), 'modal-lg', null, '1');
        });
        
        $('#menu_lst_apps').change(function () {
            datatable.draw();
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
                    d.application = $('#menu_lst_apps').val();
                }
            },
            order: [[1, 'asc']],
            columns: [
                {data: 'selection', name: 'selection', orderable: false, searchable: false},
                {data: 'designation', name: 'designation'},
                {data: 'url', name: 'url'},
                {data: 'application', name: 'application'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            KTMenu.init(); // reinit KTMenu instances 
        });
    }
    
    
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_menu');

            if (!table) {
                return;
            }

            sysMenu();
            handleSearchDatatable();
            //handleFilterDatatable();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSMenu.init();
});

function install_menu(me) {
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
            axios.post($('#dt_menu').data('url-install'),
                    {
                        id: $(me).data('id')
                    }).then(response => {
                KTApp.hidePageLoading();
                switch (response.data.status) {
                    case 'success':
                        notify(lang.msg_save_succes, "success");
                        datatable.ajax.reload();
                        $('#btn_menu_cancel').click();
                        break;
                    case 'fail':
                        submitButton.disabled = false;
                        notify(lang.msg_save_fail, "error");
                        break;
                    default:
                        submitButton.disabled = false;
                        notify(lang.msg_save_fail, "error");
                        break;
                }
            }).catch(error => {
                notify(error, "error");
                KTApp.hidePageLoading();
            });
        }
    });
}
