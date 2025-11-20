"use strict";

var handleForm;

var table_type_doc;
var dt_type_doc;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_matrimoniale;

    handleForm = function (form, fieldset, submitButton) {
        var validator = FormValidation.formValidation(
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

    $('#btn_numero_serie').click(function () {
        var form = document.querySelector('#frm_courrier_numero_prefixe');
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
                set_fname_by_selector('#tbl_fichier_joint .fichierjoint', 'fichierjoint[]');
                KTApp.showPageLoading();
                axios.post($(form).data('url'), new FormData(form))
                        .then(response => {
                            KTApp.hidePageLoading();
                            switch (response.data.status) {
                                case 'success':
                                    notify(lang.msg_save_succes, "success");
                                    $('#btn_new_courrier_cancel').click();
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
    
    var handleEdit = (m) => {
        $(m).click(function () {
            ks_load_modal($(table).data('url-edit'), $(this).data('modal-size'), {id: $(this).data('id')}, '1');
        });
    };

    var handle_edit_type_doc = () => {
        $('.edit_type_doc_row').click(function () {
            ks_load_view($(this).data('edit-url'), null, {id: $(this).data('id')});
        });
    };

    var handleStatut = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var statut = $(this).data('statut');
            var url = $(this).data('statut-url');
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
                    axios.post(url, {id: id, statut: statut})
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


    var list = function () {
        
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
        });

        $('#btn_new_type_doc').click(function () {
            ks_load_view($(this).data('url'));
        });

        var handlePreview = (m) => {
            $(m).click(function () {
                ks_displays_file($(this).data('path'));
            });
        };
        
        dt_type_doc = $(table_type_doc).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_type_doc.on('draw', function () {
            KTMenu.init();
            handleEdit('.edit_row');
            handleStatut('.status_row');
        });
       
    };
    
     var handleSearchDtTypeDoc = () => {
            const filterSearch = document.querySelector('[dt-type-doc-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                dt_type_doc.search(e.target.value).draw();
            });
        };
    // Public methods
    return {
        init: function () {
            table_type_doc = document.querySelector('#dt_type_doc');
            list();
            handleSearchDtTypeDoc();
            handleEdit('.edit_row');
            handle_edit_type_doc();
            handleStatut('.status_row');
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
});
