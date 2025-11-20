"use strict";

var datatable_hf;
var datatable_hfd;
var datatable_gal;

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_hf;
    var table_hfd;
    var table_gal;
    var submitButton;
    var validator;
    var form;

    var handleForm = function (form, submitButton) {
        var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'fichierjoint': {
                            validators: {
                                notEmpty: {
                                },
                            }
                        },
                        'role': {
                            validators: {
                                notEmpty: {
                                },
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
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_cancel').click();
                                                    $('#menu_item_25').click();
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

    var list = function () {
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), 'modal-md', {callback: $(this).data('callback')}, '1');
        });
        
        var handleEditContent = () => {
            $('.row_edit_content').click(function () {
                ks_load_view($(table_hf).data('edit-hf-url'), null, {id: $(this).data('id')});
            });
        };
        
    var handleEditContentHFD = () => {
            $('.row_edit_content_hfd').click(function () {
                ks_load_view($(table_hfd).data('edit-url'), null, {id: $(this).data('id')});
            });
        };
        
        var handleDelete = () => {
            $('.delete_row').click(function () {
                var id = $(this).data('id');
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
                        axios.post($(table_gal).data('delete-url'), {id: id})
                                .then(response => {
                                    KTApp.hidePageLoading();
                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            $($('#kt_app_content').data('menu-id')).click();
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
        
        var handlePreview = () => {
            $('.preview_row').click(function () {
                ks_load_modal($(table_hf).data('preview-url'), 'modal-xl', {id: $(this).data('id')}, '1');
            });
        };
        
        var handlePreviewHFD = () => {
            $('.preview_row_hfd').click(function () {
                ks_load_modal($(table_hf).data('preview-url'), 'modal-xl', {id: $(this).data('id'), direction: $(this).data('direction')}, '1');
            });
        };
        
        var handleEdit = () => {
            $('.edit_row').click(function () {
                ks_load_modal($(table).data('edit-url'), 'modal-md', {id: $(this).data('id')}, '1');
            });
        };
        
        var handleCodehtml = () => {
            $('.codehtml_row').click(function () {
                ks_load_modal($(this).data('codehtml-url'), 'modal-md', {id: $(this).data('id')}, '1');
            });
        };
        
        
        var handleStatut = () => {
            $('.status_row').click(function () {
                var id = $(this).data('id');
                var statut = $(this).data('statut');
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
                        axios.post($(table).data('statut-url'), {id: id, statut: statut})
                                .then(response => {
                                    KTApp.hidePageLoading();
                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            $($(table).data('menu-id')).click();
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

        datatable_gal = $(table_gal).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0},
            ]
        });
        datatable_gal.on('draw', function () {
            KTMenu.init();
            handleEdit();
            handleDelete();
            handleCodehtml();
        });

        datatable_hf = $(table_hf).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0},
            ]
        });
        datatable_hf.on('draw', function () {
            KTMenu.init();
            handleEditContent();
            handlePreview();
        });
        
        datatable_hfd = $(table_hfd).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0},
            ]
        });
        datatable_hfd.on('draw', function () {
            KTMenu.init();
            handleEditContentHFD();
            handlePreviewHFD();
        });
    };


    var handleSearchHFDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter-header_footer="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable_hf.search(e.target.value).draw();
        });
    };
    
    var handleSearchGALDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter-gallerie="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable_gal.search(e.target.value).draw();
        });
    };

    // Public methods
    return {
        init: function () {
            table_hf = document.querySelector('#dt_list_header_footer');
            table_hfd = document.querySelector('#dt_list_header_footer_direction');
            table_gal = document.querySelector('#dt_gallerie');
            list();
            handleSearchHFDatatable();
            handleSearchGALDatatable();
        },
        initForm: function () {
            var form = document.querySelector('#frm_gallerie');
            var submitButton = document.querySelector('#btn_submit');
            handleForm(form, submitButton);
        },
        initHFD: function () {
            $('#frm_header_footer .fselect2').select2({allowClear: true});
            var form = document.querySelector('#frm_header_footer');
            var submitButton = document.querySelector('#btn_submit');
            handleForm(form, submitButton);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
});
