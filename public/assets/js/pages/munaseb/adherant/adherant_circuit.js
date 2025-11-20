"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;
var table_fj;
var dt_fj ; 

var KSPara = function () {
    var submitButton;
    var form;
    let fieldIndex = 0;

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
    });

    $("#btn_new_adherant_cancel").click(function () {
        $('#menu_item_33').click();
    });

    $("#img_loader").click(function () {
        ks_load_image_resizer('frm_adherant_new', 'photo_preview', '110', '120', 'true', (110 / 120));
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

          
    $(document).on('click', '.delete_row', function () {
        var id = $(this).data('id');
        var fname = $(this).data('fname');
        var url = $('#tbl_fichier_joint').data('delete-url');
        var $btn = $(this); // bouton cliqué

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
                KTApp.showPageLoading();

                axios.post(url, { id: id, fname: fname })
                    .then(response => {
                        KTApp.hidePageLoading();

                        if (response.data.status === 'success') {
                            notify(lang.msg_save_succes, "success");

                            // supprimer la ligne du tableau
                            var row = $btn.closest('tr');
                            dt_fj.row(row).remove().draw();
                        } else {
                            notify(lang.msg_save_fail, "error");
                        }
                    })
                    .catch(error => {
                        KTApp.hidePageLoading();
                        notify(error.response?.data?.message || error.message, "error");
                    });
            }
        });
    });


    var handlePreview = (m) => {
        $('.preview').on('click', function () {
        let path = $(this).data('path');
        console.log('Preview clicked:', path);
        ks_displays_file(path);
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
                                                    $('#btn_new_adherant_cancel').click();
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
            form = document.querySelector('#frm_adherant_new');
            submitButton = $('.btn-save-circuit');
            
            handlePreview('#dt_fichier_joint .preview');
            $('#frm_adherant_new .fselect2').select2();
            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            handleForm();
        },
        initCircuit: function () {
            
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSPara.init();
});