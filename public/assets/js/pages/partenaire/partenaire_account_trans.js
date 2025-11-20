"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
// Class definition
var KSNewuser = function () {
    // Define shared variables
    var submitButton;
    var validator;
    var form;

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'idPartenaire': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'profile': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'defaulpwd': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'nomPrenoms': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'email': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'login': {
                            validators: {
                                notEmpty: {
                                },
                                remote: {
                                    data: function () {
                                        return {id: $('#user_acct_id').val(), _token: $(form).data('token')};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'POST',
                                    url: $(form).data('validate-login-url')
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
            // Validate form before submit
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
                                                    $('#btn_new_acct_cancel').click();
                                                    datatable.ajax.reload();
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
    }

    return {
        init: function () {
            form = document.querySelector('#frm_new_acct');
            submitButton = document.querySelector('#btn_new_acct_submit');
            handleForm();
            $('#frm_new_acct .fselect2').select2();
            $('#acct_personnel').select2({minimumInputLength: 2});
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSNewuser.init();
});
