"use strict";
var handleForm;
var datatable;
var table;

// Class definition

function ajax_reload_page() {
    ks_load_view('https://localhost/ecenou/home/agenda','#menu_home');
}

var KSAgenda = function () {
    $('.btn_new').click(function () {
        ks_load_modal($(this).data('url'), 'modal-md');
    });

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
                                        datatable.draw();
                                        break;
                                    case 'fail-traitement':
                                        notify('Suppression inpossible: Un ou plusieures traitements associés', "error");
                                        break;
                                    case 'fail-affectation':
                                        notify('Suppression inpossible: Une ou plusieures affectations associées', "error");
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
    
    var handleEdit = () => {
        $('.edit_row').click(function () {
            ks_load_modal($(table).data('url-edit'), 'modal-md', {id: $(this).data('id')}, '1');
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
                {data: 'designation', name: 'designation'},
                {data: 'dd', name: 'dd'},
                {data: 'df', name: 'df'},
                {data: 'niveauAccess', name: 'niveauAccess'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            rowCallback: function (row, data) {
                if (data.isRead === 0) { // Change the condition based on your requirement
                    $(row).css('font-weight', 'bold');
                }
            }
        });
        datatable.on('draw', function () {
            KTMenu.init();
            handleEdit();
            handleDelete('.delete_row');
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-menu-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_agenda');
            handleDT();
            handleSearchDatatable();
        },
        init_new: function () {
            var form = document.querySelector('#frm_agenda');
            var submitButton = document.querySelector('#btn_submit');
             var dateDebut = $('#dateDebut').flatpickr({
                    clickOpens: false, 
                    allowInput: false,
                    locale: currentLanguage,
                    altInput: true,
                    altFormat: "d F Y",
                    dateFormat: "Y-m-d"
                });
                document.getElementById("picker_dd").addEventListener("click", function () {
                    dateDebut.open();
                });
                var dateFin = $('#dateFin').flatpickr({
                    clickOpens: false, 
                    allowInput: false,
                    locale: currentLanguage,
                    altInput: true,
                    altFormat: "d F Y",
                    dateFormat: "Y-m-d"
                });
                document.getElementById("picker_df").addEventListener("click", function () {
                    dateFin.open();
                });
                $('#frm_agenda .fselect2').select2();
                $('.niveauAccess').change(function() {
                    $('#idHierarchie').select2('val','');
                    if($(this).val() == 'restraint'){
                        $('#directionservice').removeClass('hide');
                    } else {
                        $('#directionservice').addClass('hide');
                    }
                });
                var fieldset = {
                    'designation': {
                        validators: {
                            notEmpty: {
                            },
                        }
                    }
                };
            handleForm(form, fieldset, submitButton);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSAgenda.init();
});
