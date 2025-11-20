"use strict";

var datatable;
var table;
var validator, form, submitButton;
var fieldIndex = 0;
// Class definition

var KSAdherant = function () {
    $('.btn_new').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'));
    });
    
    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });
    
    $('#adherant_import').change(function () {
        KTApp.showPageLoading();
        $('#frm_adherant_import').submit();
    });
    
    $("#btn_new_adherant_cancel").click(function () {
        $('#menu_item_33').click();
    });
    
    var findAdherant = function () {
        $('#mdl_idAdherant').val(0);
        $('#mdl_nomPrenoms, #mdl_plafond').val('');
        let codeAdherant = $('#mdl_codeAdherant').val();
        axios.get($(form).data('url-adherantfinder'),  {params: {codeAdherant: codeAdherant}})
        .then(response => {
            KTApp.hidePageLoading();
            switch (response.data.status) {
                case 'success':
                    $('#mdl_idAdherant').val(response.data.adherant.id);
                    $('#mdl_nomPrenoms').val(response.data.adherant.nom + ' ' + response.data.adherant.prenoms);
                    $('#mdl_plafond').val(accounting.formatNumber(response.data.adherant.plafond));
                    var datelimit_renouvellement = new Date(addDays(response.data.adherant.dateValidite, 14, 'en'));
                    var today = new Date();
                    var dateRef = new Date();
                    var dateValidite = new Date(response.data.adherant.dateValidite);
                    if(dateValidite >= dateRef){
                        dateRef = response.data.adherant.dateValidite;
                    } else {
                        dateRef = date_format('today', 'db');
                    }
                    var dateEffet = addDays(dateRef, 30, 'en');
                    if(today < datelimit_renouvellement){
                        dateEffet = addDays(dateRef, 1, 'en');
                    }
                    
                    $('#mdl_dateEffet').val(date_format(dateEffet));
                    $('#mdl_dateValidite').val(addDays(dateEffet, 365));
                    break;
                case 'fail':
                    notify('Adherant introuvable',"error");
                    break;
                default:
                    notify('Adherant introuvable',"error");
                    break;
            }
        })
        .catch(error => {
            notify(error, "error");
            KTApp.hidePageLoading();
        });
    };

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
            if (validator && $('#mdl_idAdherant').val() > 0) {
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
                                set_fname_by_selector('#tbl_fichier_joint .fichierjoint', 'fichierjoint[]');
                                KTApp.showPageLoading();
                                axios.post($(form).data('url'), new FormData(form))
                                        .then(response => {
                                            KTApp.hidePageLoading();
                                            switch (response.data.status) {
                                                case 'success':
                                                    notify(lang.msg_save_succes, "success");
                                                    $('#btn_cancel').click();
                                                    datatable.draw();
                                                    break;
                                                case 'fail-exist':
                                                    notify('Sauvegarde réjétée: Il existe un renouvellement non-validé de cet adhérant !', "error");
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
                }
            },
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: [0, 13], // Index of the column to center (e.g., first column)
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
                {data: 'codeAdherant', name: 'codeAdherant'},
                {data: 'ine', name: 'ine'},
                {data: 'nom', name: 'nom'},
                {data: 'prenoms', name: 'prenoms'},
                {data: 'solde', name: 'solde'},
                {data: 'tel', name: 'tel'},
                {data: 'email', name: 'email'},
                {data: 'dateEffet', name: 'dateEffet'},
                {data: 'dateValidite', name: 'dateValidite'},
                {data: 'datePaiement', name: 'datePaiement'},
                {data: 'plafond', name: 'plafond'},
                {data: 'observation', name: 'observation'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleCancelRenew('.cancel_renew');
            handleValider('.valider_renew');
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-adherant-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };

    $(document).on('click', '.action_circuit', function () {
        const id = $(this).data('id');
        const url = $(table).data('circuit-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    $(document).on('click', '.edit_row', function () {
        const id = $(this).data('id');
        const url = $(this).data('edit-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    $(document).on('click', '.consult_row', function () {
        const id = $(this).data('id');
        const url = $(this).data('consult-url');
        ks_load_view(url + '?id=' + id, null, {id: id});
    });

    var handleValider = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(table).data('validate-url');
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
                                        datatable.draw();
                                        break
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
    
    var handleCancelRenew = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(table).data('cancel-url');
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
                    axios.get(url, {params: {id: id}})
                            .then(response => {
                                KTApp.hidePageLoading();
                                switch (response.data.status) {
                                    case 'success':
                                        notify(lang.msg_save_succes, "success");
                                        datatable.draw();
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
    
    $(document).on('click', '.delete_row', function () {
        var id = $(this).data('id');
        var url = $(table).data('delete-url');
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
                                    datatable.draw();
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

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_adherant');
            handleDT();
            handleSearchDatatable();
        },
        initNew: function () {
             $("#mdl_validate_num_adherant").click(function () {
                findAdherant();
            });
            $("#mdl_codeAdherant").change(function () {
                findAdherant();
            });
            form = document.querySelector('#frm_renew_adhesion');
            submitButton = document.querySelector('#btn_submit');
            $('#mdl_datePaiement').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            var fieldset = {
                'datePaiement': {
                    validators: {
                        notEmpty: {
                        },
                    }
                },
                'dateEffet': {
                    validators: {
                        notEmpty: {
                        },
                    }
                },
                'dateValidite': {
                    validators: {
                        notEmpty: {
                        },
                    }
                },
                'codeAdherant': {
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
                fieldIndex++;
            });
            KTMenu.init();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSAdherant.init();
});
