"use strict";
var handleForm;
var datatable;
var table;
var fname;
var fieldIndex = 0;

// Class definition

function ajax_reload_table() {
    datatable.ajax.reload();
}

function close_popup() {
    $('#btn_cancel').click();
}

function breadcump_open_folder(m) {
    $('#kt_app_content').data('curent-folder', $(m).data('id'));
    datatable.ajax.reload();
    $(m).nextAll().remove();
}

var KSGed = function () {
    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });

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
                                set_fname_by_selector('.metadonne', 'metadonne[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_cancel').click();
                                                    window[$(form).data('callback')]();
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

    var handleEditfile = () => {
        $('.modifier_file').click(function () {
            ks_load_modal($(table).data('url-edit-file'), 'modal-lg', {id: $(this).data('id'), callback: $('#kt_app_content').data('callback')}, '1');
        });
    };

    var handleDeplacerfile = () => {
        $('.deplacer_file').click(function () {
            ks_load_modal($(table).data('url-deplacer-file'), 'modal-md', {id: $(this).data('id'), callback: $('#kt_app_content').data('callback')}, '1');
        });
    };

    var handleAboutFile = () => {
        $('.apropos_file').click(function () {
            ks_load_modal($(table).data('url-about-file'), 'modal-md', {id: $(this).data('id')}, '1');
        });
    };
    
    var handleAboutFolder = () => {
        $('.apropos_folder').click(function () {
            ks_load_modal($(table).data('url-about-folder'), 'modal-md', {id: $(this).data('id')}, '1');
        });
    };

    var handleSharingfile = () => {
        $('.share_file').click(function () {
            ks_load_modal($(table).data('url-share-file'), 'modal-md', {id: $(this).data('id'), callback: 'close_popup'}, '1');
        });
    };
    
    var handleSharingfolder = () => {
        $('.share_folder').click(function () {
            ks_load_modal($(table).data('url-share-folder'), 'modal-md', {id: $(this).data('id'), callback: 'close_popup'}, '1');
        });
    };

    var handleDeletefile = (m) => {
        var id = $(m).data('id');
        $(m).click(function () {
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
                    axios.post($(table).data('url-delete-file'), {id: id})
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
    
    var handleDeletefolder = (m) => {
        var id = $(m).data('id');
        $(m).click(function () {
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
                    axios.post($(table).data('url-delete-folder'), {id: id})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.ajax.reload();
                                        break;
                                    case 'fail-not-empty':
                                        notify(lang.msg_fail_not_empty, "error");
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

    var handleOpen = () => {
        $('.ouvrir').click(function () {
            ks_displays_file($(this).data('path'));
        });
    };
    
    var handleEditfolder = () => {
        $('.modifier_folder').click(function () {
            ks_load_modal($(table).data('url-edit-folder'), 'modal-lg', {id: $(this).data('id'), callback: $('#kt_app_content').data('callback')}, '1');
        });
    };
    
    var handleOpenfolder = (m) => {
        $(m).click(function () {
            $('#kt_app_content').data('curent-folder', $(this).data('id'));
            datatable.ajax.reload();
            $('#breadcump_folder').append('<i class="ki-duotone ki-right fs-2x text-primary mx-1"></i><a href="javascript:;" data-id="'+ $(this).data('id') +'" data-fname=\''+ $(this).data('fname') +'\' onclick="breadcump_open_folder(this)">'+ $(this).data('fname') +'</a>');
        });
    };

    var handleDT = function () {
        datatable = $(table).DataTable({
            responsive: true,
            info: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: $(table).data('url'),
                data: function (d) {
                    var formData = $('#koriss_left_drawer_frm').serializeArray(); // Get form data
                    $.each(formData, function (key, value) {
                        d[value.name] = value.value; // Append form fields to AJAX data
                    });

                    d.column = d.order[0].column; // Column index
                    d.dir = d.order[0].dir; // Sort direction
                    d.search = d.search.value; // Search value
                    d.length = d.length; // Length
                    d.start = d.start; // Start
                    d.folder = $('#kt_app_content').data('curent-folder');
                    d.niveauAccess = $('#kt_app_content').data('niveau-access');
                }
            },
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: [0], // Index of the column to center (e.g., first column)
                    className: 'text-center'
                }
            ],
            columns: [
                {
                    data: null,
                    name: 'order_number',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'fname', name: 'fname'},
                {data: 'size', name: 'size'},
                {data: 'updatedOn', name: 'updatedOn'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleOpen();
            handleEditfile();
            handleDeplacerfile();
            handleAboutFile();
            handleSharingfile();
            handleAboutFolder();
            handleSharingfolder();
            handleDeletefile('.delete_file');
            handleOpenfolder('.folder-opened');
            handleEditfolder('.modifier_folder');
            handleDeletefolder('.delete_folder');
        });

        const filterSearch = document.querySelector('[dt-ged-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });

    };

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_ged_content');
            handleDT();
        },
        init_share: function () {
            var form = document.querySelector('#frm_share_file');
            var submitButton = document.querySelector('#btn_submit');
            $('#frm_share_file .mfselect2').select2({allowClear: true, minimumInputLength: 2});
            var fieldset = {
            };
            handleForm(form, fieldset, submitButton);
        },
        init_file: function () {
            var form = document.querySelector('#frm_new_file');
            var submitButton = document.querySelector('#btn_submit');
            $('#frm_new_file .fselect2').select2({allowClear: true});
            $('#dateExpiration').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d"
            });
            var fieldset = {
                'designation': {
                    validators: {
                        notEmpty: {
                        },
                        remote: {
                            data: function () {
                                return {id: $('#__id').val(), 'idFolder': $('#____nf_current_forder').val()};
                            },
                            message: lang.msg_scode_desig_is_used,
                            method: 'GET',
                            url: $(form).data('validate-designation-url')
                        }
                    }
                },
            };
            handleForm(form, fieldset, submitButton);

            $('.fichierjoint').change(function () {
                $('.designation').val($(this)[0].files[0].name);
            });
            $('#idType').change(function () {
                var id = $(this).val();
                let tab = $('#div_autre_info');
                tab.empty();
                if (!$(this).val())
                    return;
                axios.get($(this).data('url-load-autre-info'), {params: {id: id}})
                        .then(response => {
                            var meta = response.data.metadonnee;
                            meta.forEach(item => {
                                switch (item.typeValeur) {
                                    case 'Select':
                                        fname = 'meta_' + fieldIndex;
                                        var opt;
                                        var r = item.listOption.split(',');
                                        r.forEach(o => {
                                            opt += '<option value="' + o + '">' + o + '</option>';
                                        });
                                        tab.append('<div class="col-md-6 fv-row fv-plugins-icon-container">' +
                                                '   <label class="fs-5 fw-semibold mb-1">' + item.designation + '</label>' +
                                                '   <select data-name="metadonne[]" id="' + fname + '" name="' + fname + '" type="text" class="form-select metadonne" placeholder="">' + opt + '</select>' +
                                                '</div>');
                                        break;
                                    case 'Date':
                                        fname = 'meta_' + fieldIndex;

                                        tab.append(
                                                '<div class="col-md-6 fv-row fv-plugins-icon-container">' +
                                                '   <label class="fs-5 fw-semibold mb-1">' + item.designation + '</label>' +
                                                '       <div class="input-group">' +
                                                '     <input type="text" class="form-control datepicker metadonne" placeholder="JJ/MM/AAAA" data-name="metadonne[]" id="' + fname + '" name="' + fname + '">' +
                                                '     <span class="input-group-text">' +
                                                '         <i class="fa fa-calendar"></i>' +
                                                '     </span>' +
                                                '    </div>' +
                                                '</div>');
                                        $('#' + fname).flatpickr({
                                            locale: currentLanguage,
                                            altInput: false,
                                            altFormat: "d F Y",
                                            dateFormat: "d/m/Y",
                                        });
                                        break;
                                    default:
                                    case 'Input':
                                        fname = 'meta_' + fieldIndex;
                                        tab.append('<div class="col-md-6 fv-row fv-plugins-icon-container">' +
                                                '   <label class="fs-5 fw-semibold mb-1">' + item.designation + '</label>' +
                                                '   <input data-name="metadonne[]" id="' + fname + '" name="' + fname + '" type="text" class="form-control form-control-solid metadonne" placeholder="">' +
                                                '</div>');
                                        break;
                                }
                                fieldIndex++;
                                tab.append('<input type="hidden" name="meta_doc_id[]" value="0" /><input type="hidden" name="meta_id[]" value="' + item.id + '" /><input type="hidden" name="meta_label[]" value="' + item.designation + '" />');
                            });
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
            });

        },
        init_deplacer: function (folder) {
            var form = document.querySelector('#frm_file_deplacer');
            var submitButton = document.querySelector('#btn_submit');

            $('#ged_tv').jstree('destroy');
            $('#ged_tv').on("changed.jstree", function (e, data) {
                if (data.selected.length) {
                    $('#__destination').val(data.node.id)
                }
            }).jstree({
                'core': {
                    'multiple': false,
                    'plugins': ['multiselect'],
                    'data': {
                        'url': $(form).data('url-tv'),
                        'dataType': 'json',
                        'data': function (node) {
                            return {"idDossierparent": node.id, 'niveauAccess': 1, idFolder: folder};
                        }
                    }
                }
            });

            $('#btn_submit').click(function () {
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
                                            window[$(form).data('callback')]();
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
        },
        init_folder: function () {
            var form = document.querySelector('#frm_new_folder');
            var submitButton = document.querySelector('#btn_submit');
            var fieldset = {
                'designation': {
                    validators: {
                        notEmpty: {
                        },
                        remote: {
                            data: function () {
                                return {id: $('#__id').val(), 'idFolder': $('#____nf_current_forder').val()};
                            },
                            message: lang.msg_scode_desig_is_used,
                            method: 'GET',
                            url: $(form).data('validate-designation-url')
                        }
                    }
                },
            };
            handleForm(form, fieldset, submitButton);
        },
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSGed.init();
});
