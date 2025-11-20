"use strict";

var handleForm;

var dt_sitmat;
var dt_etat;
var dt_zone;
var dt_type_conge;
var dt_statut;
var dt_civilite;
var dt_type_salaire;
var dt_niveau_etude;
var dt_diplome;
var dt_poste;
var dt_emplois;
var dt_fonction;
var dt_hierarchie;
var dt_regime;
var dt_type_document_identite;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_matrimoniale;
    var table_civilite;
    var table_type_document_identite;
    var table_etat;
    var table_zone_residence;
    var table_type_conge;
    var table_statut;
    var table_regime;
    var table_hierarchie;
    var table_fonction;
    var table_emplois;
    var table_poste;
    var table_type_salaire;
    var table_diplome;
    var table_niveau_etude;

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

    var list = function () {
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
        });

        var handleEdit = (m) => {
            $(m).click(function () {
                ks_load_modal($(this).data('edit-url'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
            });
        };
        
        var handlePreview = (m) => {
            $(m).click(function () {
                ks_displays_file($(this).data('path'));
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

        dt_sitmat = $(table_matrimoniale).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_sitmat.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_situation_matrimoniale .edit_row');
            handleStatut('#dt_situation_matrimoniale .status_row');
        });

        dt_etat = $(table_etat).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_etat.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_etat .status_row');
            handleEdit('#dt_etat .edit_row');
        });

        dt_zone = $(table_zone_residence).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_zone.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_zone_residence .status_row');
            handleEdit('#dt_zone_residence .edit_row');
        });

        dt_type_conge = $(table_type_conge).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_type_conge.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_type_conge .status_row');
            handleEdit('#dt_type_conge .edit_row');
        });

        dt_statut = $(table_statut).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_statut.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_statut .edit_row');
            handleStatut('#dt_statut .status_row');
        });

        dt_civilite = $(table_civilite).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_civilite.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_civilite .edit_row');
            handleStatut('#dt_civilite .status_row');
        });
        dt_regime = $(table_regime).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_regime.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_regime .edit_row');
            handleStatut('#dt_regime .status_row');
        });
        dt_hierarchie = $(table_hierarchie).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_hierarchie.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_hierarchie .edit_row');
            handleStatut('#dt_hierarchie .status_row');
        });
        dt_fonction = $(table_fonction).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_fonction.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_fonction .edit_row');
            handleStatut('#dt_fonction .status_row');
        });
        dt_emplois = $(table_emplois).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_emplois.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_emplois .edit_row');
            handleStatut('#dt_emplois .status_row');
        });
        dt_poste = $(table_poste).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_poste.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_poste .edit_row');
            handleStatut('#dt_poste .status_row');
            handlePreview('#dt_poste .preview_file');
        });
        dt_niveau_etude = $(table_niveau_etude).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_niveau_etude.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_niveau_etude .edit_row');
            handleStatut('#dt_niveau_etude .status_row');
        });
        dt_diplome = $(table_diplome).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_diplome.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_diplome .edit_row');
            handleStatut('#dt_diplome .status_row');
        });
        dt_type_salaire = $(table_type_salaire).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_type_salaire.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_type_salaire .edit_row');
            handleStatut('#dt_type_salaire .status_row');
        });
        dt_type_document_identite = $(table_type_document_identite).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_type_document_identite.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_type_doc_identite .edit_row');
            handleStatut('#dt_type_doc_identite .status_row');
        });
    };

    // Public methods
    return {
        init: function () {
            table_matrimoniale = document.querySelector('#dt_situation_matrimoniale');
            table_etat = document.querySelector('#dt_etat');
            table_zone_residence = document.querySelector('#dt_zone_residence');
            table_type_conge = document.querySelector('#dt_type_conge');
            table_statut = document.querySelector('#dt_statut');
            table_civilite = document.querySelector('#dt_civilite');
            table_regime = document.querySelector('#dt_regime');
            table_hierarchie = document.querySelector('#dt_hierarchie');
            table_fonction = document.querySelector('#dt_fonction');
            table_emplois = document.querySelector('#dt_emplois');
            table_poste = document.querySelector('#dt_poste');
            table_diplome = document.querySelector('#dt_diplome');
            table_niveau_etude = document.querySelector('#dt_niveau_etude');
            table_type_salaire = document.querySelector('#dt_type_salaire');
            table_type_document_identite = document.querySelector('#dt_type_doc_identite');
            list();
        },
        init_situation_matrimonial: function () {
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
        },
        init_etat: function () {
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
        },
        init_zone_residence: function () {
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
        },
        init_type_conge: function () {
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
                },
                'nbJoursAnnuel' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_statut: function () {
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
        },
        init_civilite: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_regime: function () {
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
        },
        init_hierarchie: function () {
            $('#hierarchie_liste').select2();
            $('#hierarchie_personnel').select2({minimumInputLength: 2});
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_fonction: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_emplois: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_type_salaire: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_type_document_identite: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_diplome: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_niveau_etude: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
        init_poste: function () {
            var form = document.querySelector('#frm_new_para');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'code': {
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
                },
                'designation' : {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);
        },
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
});
