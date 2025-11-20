"use strict";

var datatable;
var table;
// Class definition

var KSBonachat = function () {
    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });
    
    $('.btn_new').click(function () {
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
            rowCallback : function (row, data) {
                $(row).addClass(data.circuitClass);
            },
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: [0], // Index of the column to center (e.g., first column)
                    className: 'text-center'
                },
                {
                    targets: [9], // Index of the column to center (e.g., first column)
                    className: 'text-end'
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
                {data: 'numBon', name: 'numBon'},
                {data: 'nature', name: 'nature'},
                {data: 'etudiant', name: 'etudiant'},
                {data: 'datebon', name: 'datebon'},
                {data: 'observation', name: 'observation'},
                {data: 'agence', name: 'agence'},
                {data: 'designationAction', name: 'designationAction'},
                {data: 'partenaire', name: 'partenaire'},
                {data: 'mntTotal', name: 'mntTotal'},
                {data: 'montantPartetudiant', name: 'montantPartetudiant'},
                {data: 'montantPrisencharge', name: 'montantPrisencharge'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleEdit();
            handleCircuit();
            handleBonprint();
            handleDelete('.delete_row');
            handleConsulter();
        });
    };
    
     var handleBonprint = () => {
        $('.print_bon').click(function () {
            ks_load_modal($(table).data('bon-url'), 'modal-xl', {
                            id: $(this).data('id'),
                        }, '1');
        });
    };
    
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };
    
    var handleEdit = () => {
        $('.edit_row').click(function () {
            ks_load_view($(table).data('edit-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
        });
    };
    
    var handleCircuit = () => {
        $('.action_circuit').click(function () {
            ks_load_view($(table).data('circuit-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
        });
    };
    
    var handleDelete = (m) => {
        $(m).click(function () {
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
    
    var handleConsulter = () => {
        $('.consult_row').click(function () {
            ks_load_view($(table).data('consult-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id'), affectation: $(this).data('affectation')});
        });
    };
    
    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_bonachat');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSBonachat.init();
});
