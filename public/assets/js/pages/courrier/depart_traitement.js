"use strict";
var handleForm;
var table, dt_traitement, validator, tbl_file;

function ajax_reload_page() {
    $('.btn-refresh-right').click();
}

var KSCourrier = function () {
    var submitButton;
    var form;
    let fieldIndex = 0;

    var handleForm = function (form, fieldset, submitButton) {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: fieldset,
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
                            focusConfirm: false, 
                            allowOutsideClick: false,  // Prevents unwanted closing
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
                                set_fname_by_selector('#tbl_fichier_joint_traitement .fichierjoint', 'fichierjoint[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_cancel').click();
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
                    }
                });
            }
        });
    };
    
    var handleFJDelete = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var fname = $(this).data('fname');
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
                    axios.post(url, {id: id, fname: fname})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        tbl_remove_row(m);
                                        ajax_reload_page();
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
    
    var handleDelete = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(table).data('url-delete');
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
                                        ajax_reload_page();
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

    var handleEdit = (m) => {
        $(m).click(function () {
            ks_load_modal($(table).data('url-edit'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
        });
    };

    $('.btn_new').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback'), idCourrier: $('#__id_courrier').val()}, '1');
    });


    var handlePreview = (m) => {
        $(m).click(function () {
            ks_displays_file($(this).data('path'));
        });
    };

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
    });

    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_110').click();
    });

    return {
        init: function () {
            table = document.querySelector('#dt_traitement');
            form = document.querySelector('#frm_courrier_new');
            submitButton = document.querySelector('#btn_new_courrier_submit');

            dt_traitement = $(table).DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
                'columnDefs': [
                    {orderable: false, targets: 0}
                ]
            });
            dt_traitement.on('draw', function () {
                KTMenu.init();
                handleEdit('#dt_traitement .edit');
                handleDelete('#dt_traitement .delete');
            });

            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d"
            });
            $('.datetimepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                enableTime: true,
                altFormat: "d F Y H:i",
                dateFormat: "Y-m-d H:i",
            });
            handlePreview('#tbl_fichier_joint .preview');
        },
        init_traitement: function () {
            var form = document.querySelector('#frm_traitement');
            var submitButton = document.querySelector('#btn_submit');
            var picker = $('#tt_dateTraitement').flatpickr({
                clickOpens: false, 
                allowInput: false,
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d"
            });
            document.getElementById("picker_opener").addEventListener("click", function () {
                picker.open();
            });
            var fieldset = {
                'dateTraiment': {
                    validators: {
                        notEmpty: {
                        },
                    }
                },
                'designation': {
                    validators: {
                        notEmpty: {
                        },
                    }
                }
            };
            handleForm(form, fieldset, submitButton);

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
            KTMenu.init();
            handleFJDelete('#tbl_fichier_joint_traitement .delete_row');
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSCourrier.init();
    KTMenu.init();
});