"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;
var fieldIndex = 0;

function set_jquery_validator(me) {
    var current = $(me).parents('tr').find('.jquery_validator').val();
    if ($(me).is(':checked')) {
        $(me).parents('tr').find('.jquery_validator').val(current + $(me).val() + ', ');
    } else {
        $(me).parents('tr').find('.jquery_validator').val(trim(current.replace($(me).val() + ',', '')));
    }
}

function display_liste_choix(me) {
    if ($(me).val() == 'Select') {
        $(me).parents('tr').find('.liste_choix').removeClass('hide');
    } else {
        $(me).parents('tr').find('.liste_choix').addClass('hide');
    }
}

var KSMain = function () {
    // Define shared variables
    var submitButton;
    var form;
    
    var handleNaturerow = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(this).data('delete-url');
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
                                         $(m).parents('tr').remove();
                                        notify(lang.msg_save_succes, "success");
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
    
    var nature = function () {
        
        $('.btn-refresh-right').click(function () {
            ks_load_view($(this).data('url'), null, {id: $(this).data('id')});
        });
        
        $('.btn-add-row-type-donnee').click(function () {
             fieldIndex++;
            let fname = 'meta_' + fieldIndex;
            $('#dt_nature_courrier tbody').append(
                    '<tr>' +
                    '    <td><input class="form-control form-control-solid libelle_propriete" placeholder="" type="text" id="' + fname + '" name="' + fname + '[]" /></td>' +
                    '    <td><input type="hidden" name="idPropriete[]" value="0" />' +
                    '        <select onchange="display_liste_choix(this)" class="form-select" name="type_valeur[]">' +
                    '            <option value="Input">Zone de saisie</option>' +
                    '            <option value="Select">Liste de choix</option>' +
                    '            <option value="Date">Date</option>' +
                    '        </select>' +
                    '        <textarea class="liste_choix form-control form-control-solid hide" name="liste_choix[]" placeholder="Liste de valeur possible separé par virgule"></textarea>' +
                    '        <input name="jquery_validator[]" value="" type="hidden" class="jquery_validator" />' +
                    '        <input name="is_filterable[]" type="hidden" value="0" class="is_filterable" />' +
                    '    </td>' +
                    '    <td>' +
                    '        <div class="checkbox"><label><input disabled onchange="set_jquery_validator(this)" value="required" type="checkbox"> Requis </label></div>' +
                    '        <div class="checkbox"><label><input disabled onchange="set_jquery_validator(this)" value="custom[number]" type="checkbox"> Numérique</label></div>' +
                    '    </td>' +
                    '    <td class="ac">' +
                    '        <button type="button" class="btn btn-sm btn-warning" title="Supprimer" onclick="tbl_remove_row(this)"><i class="fa fa-times"></i></button>' +
                    '    </td>' +
                    '</tr>'
                    );
            validator.addField(fname, {
                validators: {
                    notEmpty: {
                        message: lang.msg_required,
                    },
                },
            });
        });

        $("#btn_nature_cancel").click(function () {
            $('#menu_item_113').click();
        });

    };

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'code': {
                            validators: {
                                notEmpty: {
                                },
                                remote: {
                                    data: function () {
                                        return {id: $('#______id').val(), _token: $(form).data('token')};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'GET',
                                    url: $(form).data('validate-url'),
                                }
                            }
                        },
                        'designation': {
                            validators: {
                                notEmpty: {
                                }
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

        // Action buttons
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
                                cancelButton: "btn btn-secondary",
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                set_fname_by_selector('#dt_nature_courrier .libelle_propriete', 'libelle_propriete[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $("#btn_nature_cancel").click();
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
                    }
                });
            }
        });
    };

    return {
        init: function () {
            form = document.querySelector('#frm_nature_courrier');
            submitButton = document.querySelector('#btn_nature_submit');
            handleForm();
            nature();
            handleNaturerow('.delete_nature_row');
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSMain.init();
});
