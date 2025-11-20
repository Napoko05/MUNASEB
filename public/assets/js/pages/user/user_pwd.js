"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);

// Class definition
var KSPassword = function () {
    var submitButton;
    var validator;
    var form;

    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'oldpwd': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'newpwd': {
                            validators: {
                                notEmpty: {
                                },
                                stringLength: {
                                    min: 8,
                                },
                                regexp: {
                                    regexp: /[A-Z]/,
                                },
                                regexp: {
                                    regexp: /[!@#$%^&*(),.?":{}|<>]/,
                                }
                            }
                        },
                        'confnewpwd': {
                            validators: {
                                notEmpty: {
                                },
                                identical: {
                                    compare: function () {
                                        return document.querySelector('[name="newpwd"]').value;
                                    },
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
                                                    $('#btn_cancel').click();
                                                    break;
                                                case 'fail':
                                                    submitButton.disabled = false;
                                                    notify(lang.msg_save_fail, "error");
                                                    break;
                                                case 'oldpwd':
                                                    submitButton.disabled = false;
                                                    notify(response.data.message, "error");
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
        // Public functions
        init: function () {
            // Elements
            form = document.querySelector('#frm_user_pwd');
            submitButton = document.querySelector('#btn_submit_pwd');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSPassword.init();
});