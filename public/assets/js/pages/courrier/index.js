"use strict";

var handleForm;

var dt_partenaire;
var tbl_partenaire;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_matrimoniale;

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

    $('#btn_numero_serie').click(function () {
        var form = document.querySelector('#frm_courrier_numero_prefixe');
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
                set_fname_by_selector('#tbl_fichier_joint .fichierjoint', 'fichierjoint[]');
                KTApp.showPageLoading();
                axios.post($(form).data('url'), new FormData(form))
                        .then(response => {
                            KTApp.hidePageLoading();
                            switch (response.data.status) {
                                case 'success':
                                    notify(lang.msg_save_succes, "success");
                                    $('#btn_new_courrier_cancel').click();
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
    });
    
    var handleEdit = (m) => {
        $(m).click(function () {
            ks_load_modal($(this).data('edit-url'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
        });
    };

    var handle_edit_nature = () => {
        $('.edit_nature_row').click(function () {
            ks_load_view($(this).data('edit-url'), null, {id: $(this).data('id')});
        });
    };

    var handleStatut = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var statut = $(this).data('statut');
            var url = $(this).data('statut-url');
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
                                        $($('#kt_app_content').data('menu-id')).click();
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

    var handle_dt_partenaire = function () {
        dt_partenaire = $(tbl_partenaire).DataTable({
            responsive: true,
            info: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: $(tbl_partenaire).data('url'),
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
                {data: 'code', name: 'code'},
                {data: 'designation', name: 'designation'},
                {data: 'email', name: 'email'},
                {data: 'personneRessources', name: 'personneRessources'},
                {data: 'contactPersonneressources', name: 'contactPersonneressources'},
                {data: 'statut', name: 'statut'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        dt_partenaire.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_partenaire .edit_row');
            handleStatut('#dt_partenaire .status_row');
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt_partenaire.search(e.target.value).draw();
        });
    };

    var list = function () {

        $('#index_direction').change(function () {
            var v = $(this).val();
            $('#tbl_emplacement tbody tr').each(function(){
                if($(this).data('direction') == v){
                    $(this).removeClass('hide');
                } else {
                    $(this).addClass('hide');
                }
            });
        });
        
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
        });

        $('#btn_new_nature').click(function () {
            ks_load_view($(this).data('url'));
        });

        var handlePreview = (m) => {
            $(m).click(function () {
                ks_displays_file($(this).data('path'));
            });
        };

    };

    // Public methods
    return {
        init: function () {
            tbl_partenaire = document.querySelector('#dt_partenaire');
            list();
            handle_dt_partenaire();
            handleEdit('.edit_row');
            handle_edit_nature();
            handleStatut('.status_row');
            handleSearchDatatable();
        },
        init_emplacement: function () {
            $('#frm_new_para .fselect2').select2();
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
                    validators: {
                        notEmpty: {
                        },
                        remote: {
                            data: function () {
                                return {id: $('#__id').val(), 'idDirection': $('#____idDirection').val()};
                            },
                            message: lang.msg_scode_desig_is_used,
                            method: 'GET',
                            url: $(form).data('validate-code-url')
                        }
                    }
                },
                'idDirection': {
                    validators: {
                        notEmpty: {
                        },
                    }
                },
                'designation': {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_action: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'designation': {
                    validators: {
                        notEmpty: {
                        },
                        remote: {
                            data: function () {
                                return {id: $('#__id').val()};
                            },
                            message: lang.msg_scode_desig_is_used,
                            method: 'GET',
                            url: $(form).data('validate-code-url')
                        }
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
});
