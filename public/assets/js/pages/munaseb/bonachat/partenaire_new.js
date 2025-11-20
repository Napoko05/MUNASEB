"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

var KSPartenaire = function () {
    var submitButton;
    var form;
    let fieldIndex = 0;

    

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'));
    });

    $("#btn_new_partenaire_cancel").click(function () {
        $('#menu_item_42').click();
    });

    $("#img_loader").click(function () {
        ks_load_image_resizer('frm_personnel_new', 'photo_preview', '110', '120', 'true', (110 / 120));
    });

    $(".btn_fj_add").click(function () {
        let fname = 'fj_' + fieldIndex;
        $('#' + $(this).data('tname')).append(
                '<tr>' +
                '<td class="text-left fv-row fv-plugins-icon-container"><input onchange="set_fname(this)" class="form-control form-control-solid fichierjoint" type="file" id="' + fname + '" name="' + fname + '"></td>' +
                '<td class="text-left"><input class="form-control form-control-solid fname" type="text" name="fname[]"></td>' +
                '<td class="text-center"><button onclick="tbl_remove_row_with_validator(this)" type="button" class="btn btn-sm btn-warning"><i class="fa fa-times"></i></button></td>' +
                '</tr>');
        validator.addField(fname, {
            validators: {
                notEmpty: {
                    message: lang.msg_required,
                },
            },
        });
        fieldIndex++;
    });

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'code': {
                            validators: {
                                remote: {
                                    data: function () {
                                        return {id: $('#__id').val()};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'GET',
                                    url: $(form).data('validate-partenaire-url')
                                }
                            }
                        },
                        'designation': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'type': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'responsable': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'responsabletel': {
                            validators: {
                            }
                        },
                        'ifu': {
                            validators: {
                            }
                        },
                        'rccm': {
                            validators: {
                            }
                        },
                        'regime': {
                            validators: {
                            }
                        },
                        'divisionfisc': {
                            validators: {
                            }
                        },
                        'ville': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'adresse': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'tel': {
                            validators: {
                                notEmpty: {
                                }
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
                                set_fname_by_selector('#tbl_fichier_joint .fichierjoint', 'fichierjoint[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_new_partenaire_cancel').click();
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

                    } else {
                        notify(lang.msg_data_imcomplet, "error");
                    }

                });
            }
        });
    };

    return {
        init: function () {
            form = document.querySelector('#frm_partenaire_new');
            submitButton = document.querySelector('#btn_new_partenaire_submit');
            $('#frm_partenaire_new .fselect2').select2();
            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            handleForm();
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSPartenaire.init();
});