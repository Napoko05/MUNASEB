"use strict";
var handleForm;
var datatable;
var table;

// Class definition

function ajax_reload_page() {
    $('#menu_item_109').click();
}

var KSCourrier = function () {
    
    $('.btn_new').click(function () {
        ks_load_view($(this).data('url'));
    });

    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });

    handleForm = function (form, fieldset, submitButton) {
        var validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: fieldset,
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
        );
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
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
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_cancel').click();
                                                    ajax_reload_page();
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
                                        })
                                        .catch(error => {
                                            notify(error, "error");
                                            KTApp.hidePageLoading();
                                        });
                            }
                        });
                    }
                });
            }
        });
    };

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
                                    case 'fail-traitement':
                                        notify('Suppression inpossible: Un ou plusieures traitements associés', "error");
                                        break;
                                    case 'fail-affectation':
                                        notify('Suppression inpossible: Une ou plusieures affectations associées', "error");
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
    
    var handleMarquerTraite = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var url = $(table).data('marquer-traiter-url');
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
                    axios.post(url, {id: id, type: type})
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

    var handleTraitement = () => {
        $('.traitement').click(function () {
            ks_load_view($(table).data('traitement-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id'), affectation: $(this).data('affectation')});
        });
    };
    
    var handleFiche = () => {
        $('.ficheimputation').click(function () {
            ks_load_modal($(table).data('ficheimputation-url'), 'modal-xl', {
                            id: $(this).data('id'),
                        }, '1');
        });
    };

    var handleAffectation = () => {
        $('.affectation').click(function () {
            ks_load_view($(table).data('affectation-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id'), affectation: $(this).data('affectation')});
        });
    };

    var handleEdit = () => {
        $('.edit_row').click(function () {
            ks_load_view($(table).data('edit-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
        });
    };

    var handleConsulter = () => {
        $('.consult').click(function () {
            ks_load_view($(table).data('consult-url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id'), affectation: $(this).data('affectation')});
        });
    };

    var handleClasser = () => {
        $('.classer').click(function () {
            ks_load_modal($(table).data('classer-url'), 'modal-md',
                    {
                        id: $(this).data('id'),
                        numCourrier: $(this).data('num_courrier')
                    }, '1');
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
                    targets: [0], // Index of the column to center (e.g., first column)
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
                {data: 'numCourrier', name: 'numCourrier'},
                {data: 'dateArrive', name: 'dateArrive'},
                {data: 'dateCourrier', name: 'dateCourrier'},
                {data: 'dateLimite', name: 'dateLimite'},
                {data: 'refExterne', name: 'refExterne'},
                {data: 'nature', name: 'nature'},
                {data: 'partenaire', name: 'partenaire'},
                {data: 'objet', name: 'objet'},
                {data: 'statut', name: 'statut'},
                {data: 'emplacement', name: 'emplacement'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            rowCallback: function (row, data) {
                if (data.isRead === 0) { // Change the condition based on your requirement
                    $(row).css('font-weight', 'bold');
                }
            }
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleFiche();
            handleEdit();
            handleAffectation();
            handleTraitement();
            handleDelete('.delete_row');
            handleMarquerTraite('.marktraite');
            handleConsulter();
            handleArchive('.archiver');
            handleClasser();
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
            table = document.querySelector('#dt_courrier_arrivee');
            handleDT();
            handleSearchDatatable();
        },
        init_classer: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            $('#frm_new_para .fselect2').select2();
            var fieldset = {
                'emplacement': {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSCourrier.init();
});
