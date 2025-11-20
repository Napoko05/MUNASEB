"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

var KSMain = function () {
    var submitButton;
    var form;
    
    $(".prixUnit").keyup(function () {
        var oldSolde = accounting.unformat($('#_solde_actuel').val());
        var apport = accounting.unformat($('#montantApportadherent').val());
        tbl_total_row(this, '.qte', '.prixTotal');
        var total = tbl_total_tbody('#tbl_produit', '.prixTotal');
        var te = $('.montantPartetudiant').attr('data-taux');
        var etudiant = total*te/100 + apport;
        var prise = total - etudiant;
        var newSolde = oldSolde - prise;
        $('.montantTotal').val(accounting.formatNumber(total));
        $('.montantPartetudiant').val(accounting.formatNumber(etudiant));
        $('.montantPrisencharge').val(accounting.formatNumber(prise));
        $('.newSolde').val(accounting.formatNumber(newSolde));
    });

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'));
    });

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        
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

        submitButton.click(function (e) {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        var newSold = accounting.unformat($('#newSolde').val());
                        if(newSold < 0){
                            notify('Solde  insuffisante ! ', "error");
                            return 0;
                        }
        
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
                                                    window.location.href = $('#btn_new_bonachat_cancel').prop('href');
                                                    break;
                                                case 'fail-data':
                                                    notify('Donnée incorrecte ! ', "error");
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
            form = document.querySelector('#frm_bonachat_new');
            submitButton = $('#btn_new_bonachat_save');
            handleForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
    KTMenu.init();
});