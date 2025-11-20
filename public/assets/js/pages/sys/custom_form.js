"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);

var tags;
var datatable;
// Class definition
var KSCustom_form = function () {
    // Define shared variables
    var table;
    var submitButton;
    var validator;
    var form;
    
    var customFormNew = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'idApplication': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'formName': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'url': {
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
                                var fields = tags.value.map(item => item.value).join(',');
                                $('#tag_fields_list').val(fields);
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_new_form_cancel').click();
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
    };

    var customFormList = function () {
        
        var handleFunctions = () => {
            $('.edit_form').click(function () {
                ks_load_modal($(table).data('modedit-url'), 'modal-lg', {id: $(this).data('id')}, '1');
            });
        };
        
        var handleDelform = () => {
            $('.del_custom_form').click(function () {
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
                        axios.post($(table).data('delete-custom-form'), {id: id})
                                .then(response => {
                                    KTApp.hidePageLoading();
                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            datatable.ajax.reload();
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
        
        var handleInstallform = () => {
            $('.install_custom_form').click(function () {
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
                        axios.post($(table).data('url-install'), {id: id})
                                .then(response => {
                                    KTApp.hidePageLoading();
                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            datatable.ajax.reload();
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

        $('#btn_new_form').click(function () {
            ks_load_modal($(this).data('url'), 'modal-lg', null, '1');
        });
        
        $('#custom_form_lst_apps').change(function () {
            datatable.draw();
        });
        
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
        });

        datatable = $(table).DataTable({
            info: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: $(table).data('url'),
                data: function (d) {
                    d.column = d.order[0].column; // Column index
                    d.dir = d.order[0].dir; // Sort direction
                    d.search = d.search.value; // Search value
                    d.length = d.length; // Length
                    d.start = d.start; // Start
                    d.application = $('#custom_form_lst_apps').val();
                }
            },
            order: [[1, 'asc']],
            columns: [
                {data: 'selection', name: 'selection', orderable: false, searchable: false},
                {data: 'frmUrl', name: 'frmUrl'},
                {data: 'frmName', name: 'frmName'},
                {data: 'application', name: 'application'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            KTMenu.init(); // reinit KTMenu instances 
            handleDelform();
            handleInstallform();
            
        });
    };

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_menu');

            if (!table) {
                return;
            }

            customFormList();
            handleSearchDatatable();
            //handleFilterDatatable();
        },
        newForm: function (){
            form = document.querySelector('#frm_custom_new');
            submitButton = document.querySelector('#btn_new_form_submit');
            customFormNew();
            tags = new Tagify(form.querySelector('[name="fields"]'));
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSCustom_form.init();
});

