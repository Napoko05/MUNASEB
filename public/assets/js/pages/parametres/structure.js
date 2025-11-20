"use strict";

var dt_struc;
var dt_ty;
var dt_auto;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}
function handleDeleteAuto(m) {
    $(m).click(function () {
        var structure = $(this).data('structure');
        var personnel = $(this).data('personnel');
        var url = $('#dt_auto_agence').data('delete-url');
        var me = $(this);
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
                axios.post(url, {structure: structure, personnel: personnel})
                        .then(response => {
                            KTApp.hidePageLoading();
                            switch (response.data.status) {
                                case 'success':
                                    notify(lang.msg_save_succes, "success");
                                    //$(me).parents('tr').remove();
                                      $('[data-bs-dismiss="modal"]').click();
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
}


var KSStructure = function () {
    // Define shared variables
    var table_structure;
    var table_type;
    var table_autorisation;
    var submitButton;
    var validator;
    var form;

    var handleFormTypeStructure = function (form, submitButton) {
        var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'designation': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        }
                    },
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
                                                    window[$(form).data('callback')](result);
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

    var handleFormStructure = function (form, submitButton) {
        var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'code': {
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
                        },
                        'idType': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        },
                        'idResponsable': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        }
                    },
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
                                                    window[$(form).data('callback')](result);
                                                    $('#btn_cancel').click();
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

    var handleFormAutorisation = function (form, submitButton) {
        var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'idPersonnel': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        },
                        'idStructure': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        },
                    },
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
                                                    window[$(form).data('callback')](result);
                                                    $('#btn_cancel').click();
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

    var list = function () {
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), $(this).data('modal'), {callback: $(this).data('callback')}, '1', );
        });

        var handleEdit = (m) => {
            $(m).click(function () {
                ks_load_modal($(this).data('edit-url'), $(this).data('modal'), {id: $(this).data('id')}, '1');
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


        dt_struc = $(table_structure).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_struc.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_structure .edit_row');
            handleStatut('#dt_list_structure .status_row');
        });


        dt_ty = $(table_type).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_ty.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_type_structure .edit_row');
            handleStatut('#dt_list_type_structure .status_row');
        });

        dt_auto = $(table_autorisation).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_auto.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_autorisation .agence_row');
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch_1 = document.querySelector('[dt-menu-filter-structure="search"]');
        filterSearch_1.addEventListener('keyup', function (e) {
            dt_struc.search(e.target.value).draw();
        });

        const filterSearch_2 = document.querySelector('[dt-menu-filter-type_structure="search"]');
        filterSearch_2.addEventListener('keyup', function (e) {
            dt_ty.search(e.target.value).draw();
        });

        const filterSearch_3 = document.querySelector('[dt-menu-filter-autorisation="search"]');
        filterSearch_3.addEventListener('keyup', function (e) {
            dt_auto.search(e.target.value).draw();
        });

    };

    // Public methods
    return {
        init: function () {
            table_structure = document.querySelector('#dt_list_structure');
            table_type = document.querySelector('#dt_list_type_structure');
            table_autorisation = document.querySelector('#dt_list_autorisation');
            list();
            handleSearchDatatable();
        },
        type_structure: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            handleFormTypeStructure(form, submitButton);
        },
        structure: function () {
            $('#structure_personnel').select2({minimumInputLength: 2});
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            handleFormStructure(form, submitButton);
        },
        structure_autorisation: function () {
            $('#__idUser').select2({minimumInputLength: 2});
            $('#__idAgence').select2();
            var form = document.querySelector('#frm_new_autorisation');
            var submitButton = document.querySelector('#btn_submit');
            handleFormAutorisation(form, submitButton);
        },
        structure_autorisation_agence: function () {
            init_datatable('#dt_auto_agence', 'dt-menu-filter-autoagence');
            handleDeleteAuto('#dt_auto_agence .btn_del_auto');
        },
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSStructure.init();
});
