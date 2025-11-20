"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);

// Class definition
var KSMenu_action = function () {
    var submitButton;
    var validator;
    var btnupdaction;
    var form;

    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'menu_actions': {
                            validators: {
                                notEmpty: {
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
                }
        );
        // Action buttons
        $(submitButton).click(function (e) {
            var btnact = $(this);
            e.preventDefault();
            //if (validator) {
                validator.validate().then(function (status) { 
                    if (status == 'Valid' || $(btnact).data('action') == 'update') {
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
                                $('#set_action').val($(btnact).data('action'));
                                if($(btnact).data('action') == 'update'){
                                    var tr = $(btnact).parents('tr');
                                    if($(tr).find('.action').val()==''){
                                        $('#set_action').val('delete');
                                    }
                                    $(tr).find('.action').attr('name', 'action_code');
                                    $(tr).find('.action_id').attr('name', 'action_id');
                                }
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    if($('#set_action').val() == 'add'){
                                                        $('#modal_level_1').modal('hide');
                                                        datatable.ajax.reload();
                                                    }
                                                    if($('#set_action').val() == 'delete'){
                                                        $(btnact).parents('tr').remove();
                                                    }
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
                    }
                });
           // }
        });

    };

    return {
        init: function () {
            form = document.querySelector('#frm_menu_actions');
            //submitButton = document.querySelector('#btn_save_menu_actions');
            submitButton = $('.btnupdaction');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSMenu_action.init();
});