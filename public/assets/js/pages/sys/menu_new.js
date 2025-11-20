"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);

// Class definition
var KSMenu_new = function () {
    var submitButton;
    var validator;
    var form;
    
    var menu_order_set_parent = () => {
            $('#menu_new_level').change(function () {
                var level = $(this).val() - 1;
                $('#menu_new_id_menuparent option').each(function(){
                    if($(this).data('parent') == level){
                        $(this).removeClass('hide');
                    } else {
                        $(this).addClass('hide');
                    }
                });
                $('#________noneoption').removeClass('hide');
            });
        };
        
    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'code': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'orderBy': {
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
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            // Validate form before submit
            if($('#menu_new_level').val() > 1){
                if(!$('#menu_new_id_menuparent').val() > 0){
                    notify(lang.msg_data_incomplet, "error");
                    return 0;
                }
            }
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
                                                    $('#btn_new_menu_cancel').click();
                                                    datatable.ajax.reload();
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

                    }

                });
            }
        });
    }

    return {
        // Public functions
        init: function () {
            // Elements
            form = document.querySelector('#frm_menu_new');
            submitButton = document.querySelector('#btn_new_menu_submit');
            handleForm();
            menu_order_set_parent();
            $('#idMenuparent').select2();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSMenu_new.init();
});