"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;
var table_fj;
var dt_fj;

var KSPara = function () {
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

    var handleDelete = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var fname = $(this).data('fname');
            var url = $(dt_fichier_joint).data('delete-url');
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

    return {
        init: function () {
            form = document.querySelector('#frm_adherant_new');
            dt_fj = $('#dt_fichier_joint').DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
                'columnDefs': [
                    {orderable: false, targets: 0}
                ]
            });
            dt_fj.on('draw', function () {
                KTMenu.init();
                handlePreview('#dt_fichier_joint .preview');
            });
            $('#frm_adherant_new .fselect2').select2();
            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            init_datatable('#dt_bonachat', 'dt-bon-filter');
            init_datatable('#dt_remboursement', 'dt-remboursement-filter');
            init_datatable('#dt_detailsprestation', 'dt-detail-filter');
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSPara.init();
});