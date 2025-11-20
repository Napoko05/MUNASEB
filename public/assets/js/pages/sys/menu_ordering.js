"use strict";

// Class definition
var KSMenu_order = function () {
    var submitButton;
    var form;

    // Init form inputs
    var handleForm = function () {
        
        
        // Action buttons
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
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
                                        datatable.ajax.reload();
                                        $('#btn_menu_cancel').click();
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
        });
    }

    return {
        // Public functions
        init: function () {
            // Elements
            form = document.querySelector('#frm_menu_order');
            submitButton = document.querySelector('#btn_menu_submit');
            handleForm();
            $('#menu_ordering_place').select2();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSMenu_order.init();
});