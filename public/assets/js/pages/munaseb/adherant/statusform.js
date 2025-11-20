"use strict";

var mylocal = new Map([
    ['fr', FormValidation.locales.fr_FR],
    ['en', FormValidation.locales.en_US],
    ['ar', FormValidation.locales.ar_MA]
]);

var KSMain = function () {
    var submitButton;
    var form;
    var validator;

    var handleForm = function () {
        // Initialisation FormValidation
        validator = FormValidation.formValidation(form, {
            localization: mylocal.get(currentLanguage),
            fields: {
                'observation': {
                    validators: {
                        notEmpty: {
                            message: lang.msg_required_field
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
        });

        // Événement clic sur le bouton
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (!validator) return;

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    Swal.fire({
                        title: lang.msg_toconfirm,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: lang.msg_confirm,
                        cancelButtonText: lang.msg_cancel,
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-secondary"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Désactiver le bouton
                            submitButton.disabled = true;
                            KTApp.showPageLoading();

                            // Préparer les données
                            const formData = new FormData(form);

                            axios.post(form.dataset.url, formData)
                                .then(response => {
                                    KTApp.hidePageLoading();

                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            $('#btn_cancel').click();
                                                    setTimeout(() => {
                                                        location.reload(); // Recharge la page après succès
                                                    }, 500)
                                            break;

                                        case 'fail':
                                        default:
                                            notify(lang.msg_save_fail, "error");
                                            break;
                                    }
                                })
                                .catch(error => {
                                    notify(error.response?.data?.message || error.message, "error");
                                })
                                .finally(() => {
                                    // Réactiver le bouton
                                    submitButton.disabled = false;
                                    KTApp.hidePageLoading();
                                });
                        }
                    });
                } else {
                    notify(lang.msg_data_incomplet, "error");
                }
            });
        });
    };

    return {
        init: function () {
            form = document.querySelector('#frm_adherant_status');
            submitButton = document.querySelector('#btn_submit');
            handleForm();
        }
    };
}();

// Initialisation au chargement du DOM
KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
});
