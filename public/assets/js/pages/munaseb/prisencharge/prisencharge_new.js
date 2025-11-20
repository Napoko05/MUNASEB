"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

function prepend_option_nature(id, txt_option) {
    prepend_option('#lst_expediteur', id, txt_option);
}

var KSCourrier = function () {
    var submitButton;
    var form;
    let fieldIndex = 0;
    let fname;

    $('.btn_add_form').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
    });

  


    $(".btn_add_product").click(function () {

                var produit = $("#lst_produits").val();
                var selectedOption = $("#lst_produits option:selected");
                var produitId = selectedOption.data("id"); // récupération de data-id
                var quantite = $("#quantite").val();
                var prixUnitaire = $("#prix_unitaire").val();
                var prixTotal = $("#prix_total").val();
                

                
        
                // Vérifier que les champs sont remplis
                if (!produit) {
                    notify("Veuillez sélectionner un produit", "error");
                    return;
                }
                if (!quantite || quantite <= 0) {
                    notify("Veuillez entrer une quantité valide", "error");
                    return;
                }
        
                // Ajouter une nouvelle ligne dans le tableau
                $("#tbl_exam tbody").append(
                    `<tr>
                        <td>${produit} <input type="hidden" name="produits[]" value="${produitId}" /></td>
                        <td>${prixUnitaire} <input type="hidden" name="prix_unitaires[]" value="${prixUnitaire}" /></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning" onclick="supprimerLigne(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`
                );
        
                // Réinitialiser les champs après l'ajout
                $("#lst_produits").val("").trigger("change");
                $("#quantite").val("");
                $("#prix_unitaire").val("");
                $("#prix_total").val("");
            
        
            // Supprimer une ligne du tableau
            window.supprimerLigne = function (btn) {
                $(btn).closest("tr").remove();
                recalculerTotalGeneral();
            };
        
        
       


    });

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'));
    });

    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_40').click();
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
                        'numbon': {
                            validators: {
                                notEmpty: {
                                },
                                remote: {
                                    data: function () {
                                        return {id: $('#__id').val()};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'GET',
                                    url: $(form).data('validate-reference-url')
                                }
                            }
                        },
                        'datebon': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'medecin': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'ine': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'Nom&prenoms': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'objet': {
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
                                set_fname_by_selector('.metadonne', 'metadonne[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_new_bonachat_cancel').click();
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
            submitButton = document.querySelector('#btn_new_bonachat_submit');
            $('#frm_bonachat_new .fselect2').select2({allowClear: true});
            $('#frm_bonachat_new .mfselect2').select2({allowClear: true, minimumInputLength: 2});

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
// On document ready
KTUtil.onDOMContentLoaded(function () {
     // Mettre à jour le prix unitaire et total lors de la sélection du produit
     $("#lst_produits").change(function () {
        var prixUnitaire = $(this).find(":selected").data("prix"); // Récupérer le prix du produit sélectionné
        var produitId = $(this).find(":selected").data("id"); // Récupérer l'ID du produit sélectionné
        $("#prix_unitaire").val(prixUnitaire || ""); // Mettre à jour le champ Prix Unitaire
        calculerPrixTotal(); // Mettre à jour le prix total
    });

    // Mettre à jour le prix total lorsqu'on change la quantité
    $("#quantite").on("input", function () {
        calculerPrixTotal();
    });

    // Fonction de calcul du prix total
    function calculerPrixTotal() {
        var quantite = parseFloat($("#quantite").val()) || 0;
        var prixUnitaire = parseFloat($("#prix_unitaire").val()) || 0;
        var prixTotal = quantite * prixUnitaire;
        $("#prix_total").val(prixTotal);
    }

    function recalculerTotalGeneral() {
        let totalGeneral = 0;
    
        $("#tbl_exam tbody tr").each(function () {
            const prixTotal = parseFloat($(this).find('input[name="prix_totals[]"]').val()) || 0;
            totalGeneral += prixTotal;
        });
    
        $("#total_general").text(totalGeneral.toFixed(2));
    }
    KSCourrier.init();
    $('.btn_fj_add').click();
});