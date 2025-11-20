"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

var KSMain = function () {
    var submitButton;
    var form;

    $('.btndel').click(function () {
        var m = $(this);
        var id = $(this).data('id');
        var typerow = $(this).data('type');
        var um = $(this).data('um');
        var bon = $('#___idBon').val();
        var url = $('#tbl_produit').data('url');
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
                axios.post(url, {id: id, typerow: typerow, um: um, bon: bon})
                        .then(response => {
                            KTApp.hidePageLoading();
                            switch (response.data.status) {
                                case 'success':
                                    notify(lang.msg_save_succes, "success");
                                    $(m).parents('tr').remove();
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

    $(".prixUnit").keyup(function () {
        var oldSolde = accounting.unformat($('#_solde_actuel').val());
        var apport = accounting.unformat($('#montantApportadherent').val());
        tbl_total_row(this, '.qte', '.prixTotal');
        var total = tbl_total_tbody('#tbl_produit', '.prixTotal');
        var te = $('.montantPartetudiant').attr('data-taux');
        var etudiant = total * te / 100 + apport;
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

    $("#btn_new_bonachat_cancel").click(function () {
        $('#menu_item_40').click();
    });

    $(".btn_fj_add").click(function () {
        $('#' + $(this).data('tname')).append(
                '<tr>' +
                '<td class="text-left fv-row fv-plugins-icon-container"><input onchange="set_fname(this)" class="form-control form-control-solid " type="file" name="fichierjoint[]"></td>' +
                '<td class="text-left"><input class="form-control form-control-solid fname" type="text" name="fname[]"></td>' +
                '<td class="text-center"><button onclick="tbl_remove_row_with_validator(this)" type="button" class="btn btn-sm btn-warning"><i class="fa fa-times"></i></button></td>' +
                '</tr>');
    });

    var handleDelete = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var fname = $(this).data('fname');
            var url = $('#dt_fichier_joint').data('delete-url');
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
                    axios.post(url, {id: id, fname: fname})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        var row = $(m).closest('tr');
                                        dt_fj.row(row).remove().draw();
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

    var handlePreview = (m) => {
        $(m).click(function () {
            console.log('Preview clicked', $(this).data('path'));
            ks_displays_file($(this).data('path'));
        });
    };

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
            var newSold = accounting.unformat($('#newSolde').val());
            if (newSold < 0) {
                notify('Solde  insuffisante ! ', "error");
                return 0;
            }
            $('#__optionCircuit').val($(this).data('option'));
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
                                                    $('#btn_new_bonachat_cancel').click();
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
            submitButton = $('.btn-save-circuit');
            handleDelete('#dt_fichier_joint .delete_row');
            handlePreview('#dt_fichier_joint .preview');
            $('#frm_bonachat_new .fselect2').select2();
            handleForm();
            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            $('.datetimepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                enableTime: true,
                altFormat: "d F Y H:i",
                dateFormat: "Y-m-d H:i",
            });
            handlePreview('#tbl_fichier_joint .preview');
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
    KTMenu.init();
});