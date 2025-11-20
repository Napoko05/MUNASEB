"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

function prepend_option_nature(id, txt_option) {
    prepend_option('#lst_expediteur', id, txt_option);
}

function remboursement_remove_row(me) {
    tbl_remove_row(me);
    var total1 = tbl_total_tbody('#tbl_produit', '.prixTotal');
    var total2 = tbl_total_tbody('#tbl_examen', '.prixTotal');
    var total3 = tbl_total_tbody('#tbl_autre', '.prixTotal');
    $('.montantTotal').val(accounting.formatNumber(total1 + total2 + total3));
}

function handleSubmit(form, e, button, options = {}) {
    e.preventDefault();

    if (!(validator && $('#__idAdherant').val() > 0)) {
        return notify("blablabla", "error");
    }

    validator.validate().then(function (status) {
        if (status !== 'Valid') {
            return notify(lang.msg_data_imcomplet, "error");
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
            if (!result.isConfirmed)
                return;

            // Common
            set_fname_by_selector('#tbl_fichier_joint .fichierjoint', 'fichierjoint[]');
            set_fname_by_selector('.metadonne', 'metadonne[]');

            // Specific option
            if (options.setInit)
                $('#__hasInit').val('1');
            else
                $('#__hasInit').val('0');
            
            KTApp.showPageLoading();
            axios.post($(form).data('url'), new FormData(form))
                    .then(response => {
                        KTApp.hidePageLoading();
                        switch (response.data.status) {
                            case 'success':
                                notify(lang.msg_save_succes, "success");
                                $('#btn_new_remboursement_cancel').click();
                                break;
                            default:
                                button.disabled = false;
                                notify(lang.msg_save_fail, "error");
                                break;
                        }
                    })
                    .catch(error => {
                        notify(error, "error");
                        KTApp.hidePageLoading();
                    });
        });
    });
}

var KSMain = function () {
    var submitButton;
    var submitButtonInit;
    var form;
    let fieldIndex = 0;
    let fname;
    
    $(".prixUnit").keyup(function () {
        tbl_total_row(this, '.qte', '.prixTotal');
    });
    
    $(".qte").keyup(function () {
        tbl_total_row(this, '.prixUnit', '.prixTotal');
    });

    $('#_natureBon').change(function () {
        $('#_tauxprisencharge').val($('#_natureBon option:selected').attr('data-taux'));
    });

    $('.btn_add_form').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
    });

    $("#btn_new_remboursement_cancel").click(function () {
        $('#menu_item_52').click();
    });

    $(".btn_add_product").click(function () {
        if (!$("#lst_produits").val() || $("#tr_" + $("#lst_produits").val()).length) {
            notify("Veuillez sélectionner un produit valide", "error");
            return;
        }
        
        if (!accounting.unformat($("#prixTotal").val()) > 0) {
            notify("Veuillez entrer une quantité et un prix valide", "error");
            return;
        }
        
        $("#tbl_produit tbody").append(
                `<tr id="tr_${$("#lst_produits").val()}">
                        <td>${$('#lst_produits option:selected').text()} <input type="hidden" name="idUm[]" value="${$("#lst_produits option:selected").attr('data-um')}" /><input type="hidden" name="produits[]" value="${$("#lst_produits").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-center" readonly name="quantite[]" value="${$("#quantite").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end" readonly name="prixUnit[]" value="${$("#prixUnit").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end prixTotal" readonly name="prixTotal[]" value="${$("#prixTotal").val()}" /></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning" onclick="remboursement_remove_row(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`
                );

        // Réinitialiser les champs après l'ajout
        $("#lst_produits").val("").trigger("change");
        $("#quantite, #prixUnit, #prixTotal").val("");
        var total1 = tbl_total_tbody('#tbl_produit', '.prixTotal');
        var total2 = tbl_total_tbody('#tbl_examen', '.prixTotal');
        var total3 = tbl_total_tbody('#tbl_autre', '.prixTotal');
        $('.montantTotal').val(accounting.formatNumber(total1 + total2 + total3));
    });
    
    $(".btn_add_examen").click(function () {
        if (!$("#lst_examen").val() || $("#trex_" + $("#lst_examen").val()).length) {
            notify("Veuillez sélectionner un examen valide", "error");
            return;
        }
        
        if (!accounting.unformat($("#prixTotalExamen").val()) > 0) {
            notify("Veuillez entrer une quantité et un prix valide", "error");
            return;
        }

        $("#tbl_examen tbody").append(
                `<tr id="trex_${$("#lst_examen").val()}">
                        <td>${$('#lst_examen option:selected').text()} <input type="hidden" name="natureExamen[]" value="${$("#lst_examen").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-center" readonly name="qteExamen[]" value="${$("#quantiteExamen").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end" readonly name="prixUnitExamen[]" value="${$("#prixUnitExamen").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end prixTotal" readonly name="prixTotalExamen[]" value="${$("#prixTotalExamen").val()}" /></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning" onclick="remboursement_remove_row(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`
                );

        // Réinitialiser les champs après l'ajout
        $("#lst_examen").val("").trigger("change");
        $("#prixUnitExamen, #prixTotalExamen").val("");
        var total1 = tbl_total_tbody('#tbl_produit', '.prixTotal');
        var total2 = tbl_total_tbody('#tbl_examen', '.prixTotal');
        var total3 = tbl_total_tbody('#tbl_autre', '.prixTotal');
        $('.montantTotal').val(accounting.formatNumber(total1 + total2 + total3));
    });
    
    $(".btn_add_autre").click(function () {
        if ($("#txt_autre").val() == '') {
            notify("Veuillez sélectionner un examen valide", "error");
            return;
        }
        if (!$("#quantiteAutre").val() > 0) {
            notify("Veuillez entrer une quantité valide", "error");
            return;
        }

        $("#tbl_autre tbody").append(
                `<tr>
                        <td><textarea rows="1" class="form-control form-control-solid" name="designationAutre[]">${$('#txt_autre').val()}</textarea></td>
                        <td><input type="text" class="form-control form-control-solid text-center" readonly name="qteAutre[]" value="${$("#quantiteAutre").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end" readonly name="prixUnitAutre[]" value="${$("#prixUnitAutre").val()}" /></td>
                        <td><input type="text" class="form-control form-control-solid text-end prixTotal" readonly name="prixTotalAutre[]" value="${$("#prixTotalAutre").val()}" /></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning" onclick="remboursement_remove_row(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`
                );

        // Réinitialiser les champs après l'ajout
        $("#txt_autre, #quantiteAutre, #prixUnitAutre, #prixTotalAutre").val("");
        var total1 = tbl_total_tbody('#tbl_produit', '.prixTotal');
        var total2 = tbl_total_tbody('#tbl_examen', '.prixTotal');
        var total3 = tbl_total_tbody('#tbl_autre', '.prixTotal');
        $('.montantTotal').val(accounting.formatNumber(total1 + total2 + total3));
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
    
    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'));
    });

    $(".btn_validate_num_adherant").click(function () {
        findAdherant();
    });

    $("#__codeAdherant").change(function () {
        findAdherant();
    });

    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_40').click();
    });

    

    var findAdherant = function () {
        $('#__idAdherant, #_solde_actuel').val(0);
        $('#___nomPrenoms').val('');
        let codeAdherant = $('#__codeAdherant').val();
        axios.get($(form).data('url-adherantfinder'), {params: {codeAdherant: codeAdherant}})
                .then(response => {
                    KTApp.hidePageLoading();
                    switch (response.data.status) {
                        case 'success':
                            $('#__idAdherant').val(response.data.adherant.id);
                            $('#___nomPrenoms').val(response.data.adherant.nom + ' ' + response.data.adherant.prenoms);
                            $('#_solde_actuel').val(accounting.formatNumber(response.data.adherant.plafond - response.data.adherant.cumulRemboursement));
                            break;
                        case 'fail':
                            notify('Adherant introuvable', "error");
                            break;
                        default:
                            notify('Adherant introuvable', "error");
                            break;
                    }
                })
                .catch(error => {
                    notify(error, "error");
                    KTApp.hidePageLoading();
                });

    };

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'dateDemande': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                       
                        'codeAdherant': {
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

        submitButton.addEventListener('click', e => handleSubmit(form, e, submitButton));
        submitButtonInit.addEventListener('click', e => handleSubmit(form, e, submitButtonInit, {setInit: true}));
    };

    return {
        init: function () {
            form = document.querySelector('#frm_remboursement_new');
            submitButton = document.querySelector('#btn_new_remboursement_submit');
            submitButtonInit = document.querySelector('#btn_new_remboursement_submit_init');
            $('#_tauxprisencharge').val($('#_natureBon option:selected').attr('data-taux'));
            $('#frm_remboursement_new .fselect2').select2({allowClear: true});
            $('#frm_remboursement_new .mfselect2').select2({allowClear: true, minimumInputLength: 2});

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
            handleForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
    KTMenu.init();
});