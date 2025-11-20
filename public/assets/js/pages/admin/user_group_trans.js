"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
// Class definition
var KSUsergroup = function () {
    // Define shared variables
    var submitButton;
    var validator;
    var table;
    var form;

    var userGroupck = function () {
        
        $('.btn-refresh-right').click(function () {
            ks_load_view($(this).data('url'), null, {id: $(this).data('id')});
        });
    
        $('#check_all_access').click(function () {
            $('.access_id').prop('checked', $(this).is(':checked'));
            $('.access_action').prop('checked', $(this).is(':checked'));
            $('.btn-action').prop('disabled', !$(this).is(':checked'));
        });
        
        $("#btn_ug_cancel").click(function(){
            $('#menu_item_12').click();
        });

        $('.access_id').change(function (e) {
            let id = $(this).val();
            let tr = $(this).parents('tr');
            let status = $(this).is(':checked');
            $(tr).find('.access_action').prop('checked', status);
            $(tr).find('.btn-action').prop('disabled', !status);
            if (!status) {
                var level = $(this).data('level');
                switch (level) {
                    case 1:
                        var level2 = $('#dt_user_group_new input[data-parent="menu_' + id + '"]');
                        if (level2.length) {
                            level2.each(function () {
                                $(this).prop('checked', false);
                                var s_tr2 = $(this).parents('tr');
                                $(s_tr2).find('.access_action').prop('checked', false);
                                $(s_tr2).find('.btn-action').prop('disabled', true);
                                var level3 = $('#dt_user_group_new input[data-parent="menu_' + $(this).val() + '"]');
                                if (level3.length) {
                                    level3.each(function () {
                                        $(this).prop('checked', false);
                                        var s_tr3 = $(this).parents('tr');
                                        $(s_tr3).find('.access_action').prop('checked', false);
                                        $(s_tr3).find('.btn-action').prop('disabled', true);
                                    });
                                }
                            });
                        }
                        break;
                    case 2:
                        var level3 = $('#dt_user_group_new input[data-parent="menu_' + $(this).val() + '"]');
                        if (level3.length) {
                            level3.each(function () {
                                $(this).prop('checked', false);
                                var s_tr3 = $(this).parents('tr');
                                $(s_tr3).find('.access_action').prop('checked', false);
                                $(s_tr3).find('.btn-action').prop('disabled', true);
                            });
                        }
                        break;
                    case 3:
                        break;
                }
            }
        });
    }

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'designation': {
                            validators: {
                                notEmpty: {
                                },
                                remote: {
                                    data: function () {
                                        return {id: $('#ug_id').val(), _token: $(form).data('token')};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'POST',
                                    url: $(form).data('validate-designation-url'),
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
            var id = $('#ug_id').val();
            var designation = $('#ug_designation').val();
            var access_id = Array.from(table.querySelectorAll('tbody [name="access_id[]"]:checked')).map(checkbox => checkbox.value);
            var access_action = Array.from(table.querySelectorAll('tbody [name="access_action[]"]:checked')).map(checkbox => checkbox.value);
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
                                cancelButton: "btn btn-secondary",
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), {id: id, designation:designation, access_id: access_id, access_action: access_action})
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $("#btn_ug_cancel").click();
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
            }
        });
    }

    return {
        init: function () {
            table = document.querySelector('#dt_user_group_new');
            form = document.querySelector('#frm_user_group_trans');
            submitButton = document.querySelector('#btn_ug_submit');
            handleForm();
            userGroupck();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSUsergroup.init();
});
