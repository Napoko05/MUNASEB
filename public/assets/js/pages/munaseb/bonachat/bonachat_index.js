"use strict";

var datatable;
var table;


// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSPartenaire = function () {
    $('.btn_new').click(function () {
        ks_load_view($(this).data('url'));
    });
    
    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });

    var handleArchive = (m) => {
        $(m).click(function () {
             if ($(this).data('deleted') == '0') {
                notify($(table).data('msg_delete_first'), "error");
                return 0;
            }
            var id = $(this).data('id');
            var url = $(table).data('archiver-url');
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
    };

    
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
                                        setTimeout(() => {
                                            location.reload(); // Recharge la page après succès
                                        }, 500)
                                        /*datatable.ajax.reload(null, false);
                                        ajax_reload_page
                                        datatable.draw()*/
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
    
    

    /*var handleEdit = () => {
        $('.edit_mod').click(function () {
            ks_load_view($(table).data('edit-url')+'?id=' + $(this).data('id'), null, {id: $(this).data('id')});
        });
    };*/


   var handleEdit = () => {
    $('.edit_row').click(function () {
        let url = $(this).data('edit-url');
        let id = $(this).data('id');
        ks_load_view(url + '?id=' + id, null, { id: id });
     });
    };

    var handleConsulter = () => {
    $('.consult_row').click(function () {
        let url = $(this).data('consult-url');
        let id = $(this).data('id');
        ks_load_view(url + '?id=' + id, null, { id: id });
     });
    };
    

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
                    targets: [0, 5], // Index of the column to center (e.g., first column)
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
                {data: 'code', name: 'code'},
                {data: 'designation', name: 'designation'},
                {data: 'type', name: 'type'},
                {data: 'statut', name: 'statut'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleConsulter();
            handleEdit();
            handleArchive('.archiver');
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
            table = document.querySelector('#dt_partenaire');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSPartenaire.init();
});
