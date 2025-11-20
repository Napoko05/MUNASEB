"use strict";

var datatable;
var table;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSUmesure = function () {
    $('.btn_new').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');    
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

    
    $(document).on('click', '.edit_mod', function () {
        let editUrl = $(this).data('edit-url');
        let id = $(this).data('id');
        let callback = $(this).data('callback') || '';
        let modalSize = $(this).data('modal-size') || 'modal-md';
    
        // Appelle ta fonction personnalisée avec les bons paramètres
        ks_load_modal(editUrl, modalSize, {id: id}, '1');
    });
    
    
    

    var handleConsulter = () => {
        $('.consult').click(function () {
            let editUrl = $(this).data('consult-url'); // Récupère bien l'URL
            let id = $(this).data('id'); // Récupère l'ID
            let callback = $(this).data('callback') || ''; // Vérifie si data-callback existe
           // Appelle ks_load_view avec les données correctes
           ks_load_modal($(this).data('consult-url'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
            
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
                    targets: [0, 6], // Index of the column to center (e.g., first column)
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
                {data: 'reference', name: 'reference'},
                {data: 'designation', name: 'designation'},
                {data: 'catdesi', name: 'catdesi'},
                {data: 'qteMini', name: 'qteMini'},
                {data: 'statut', name: 'statut'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleConsulter();
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
            table = document.querySelector('#dt_produit');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSUmesure.init();
});
