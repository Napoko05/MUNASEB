"use strict";

var datatable_hf;
var datatable_gal;

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_hf;
    var table_gal;
    var submitButton;
    var validator;
    var form;


    var handleCopy = () => {
        $('.copy_row').click(function () {
            if (window.clipboardData && window.clipboardData.setData) {
                notify('Copie effectuer !', "info");
                return window.clipboardData.setData("Text", $(this).data('copy'));
            } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                try {
                    const textToCopy = $(this).data('copy');
                    const tempInput = $('<input>');
                    $('body').append(tempInput);
                    tempInput.val(textToCopy).select();
                    document.execCommand('copy');                                        // Remove the temporary input
                    tempInput.remove();
                    notify('Copie effectuer !', "info");
                } catch (ex) {
                    console.warn("", ex);
                    return false;
                }
            }
        });
    };
    var handleForm = function () {
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
                                        ajax_reload_page();
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
    };

    // Public methods
    return {
        init: function () {
            form = document.querySelector('#frm_footer_header');
            submitButton = document.querySelector('#btn_hf_submit');
            handleForm();
            handleCopy();

            var header = document.getElementById('param_header');
            var editorH = CodeMirror.fromTextArea(header, {
                lineNumbers: true,
                theme: "monokai"
            });
            editorH.on('change', function () {
                editorH.save(); // This will update the textarea's value
            });

            var footer = document.getElementById('param_footer');
            var editorF = CodeMirror.fromTextArea(footer, {
                lineNumbers: true,
                theme: "monokai"
            });
            editorF.on('change', function () {
                editorF.save(); // This will update the textarea's value
            });

            var bg = document.getElementById('param_bg');
            var editorB = CodeMirror.fromTextArea(bg, {
                lineNumbers: true,
                theme: "monokai"
            });
            editorB.on('change', function () {
                editorB.save(); // This will update the textarea's value
            });


        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
    KTMenu.init();
});
