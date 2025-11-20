"use strict";

var datatable;
var table;
// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSMain = function () {
    $('.btn_new_etape').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {circuit: $(this).data('circuit')}, '1');
    });
    
    var handleEditCV = (m) => {
        $(m).click(function () {
            ks_load_modal($(this).data('edit-url'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
        });
    };

    var handleDeleteCV = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(this).data('delete-url');
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
                    axios.post(url, {id: id})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        ks_load_view($('#kt_app_content').data('refresh-url'));
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

    return {
        init: function () {
            handleDeleteCV('.del_row_cv');
            handleEditCV('.edit_row_cv');
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSMain.init();
});
