"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;
var table, datatable, table_fj;

function prepend_option_nature(id, txt_option) {
    prepend_option('#lst_expediteur', id, txt_option);
}

var KSCourrier = function () {
    var submitButton;
    var form;
    let fieldIndex = 0;

    $('.btn_add_form').click(function () {
        ks_load_modal($(this).data('url'), $(this).data('modal-size'), {callback: $(this).data('callback')}, '1');
    });

    $('#lst_direction_service').change(function () {
        var data = 'data-direction';
        if($('#lst_direction_service option:selected').data('isdirection') == '0'){
            data = 'data-service';
        }
        filter_combo_by_data('#lst_personnel_courrier', data , this);
        if (!$('.agent_col').hasClass('hide') && !$('#personnel_' + $('#lst_direction_service option:selected').attr('data-responsable')).length) {
            $('#lst_personnel_courrier').val($('#lst_direction_service option:selected').attr('data-responsable')).trigger('change');
        }
    });
    
    var handleDeleteAffectation = (m) => {
        $(m).click(function () {
            var id = $(this).data('id');
            var url = $(table).data('delete-affectation-url');
            var idCourrier = $('#__id_courrier').val();
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
                    axios.post(url, {id: id, idCourrier: idCourrier})
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
    };

    var handlePreview = (m) => {
        $(m).click(function () {
            ks_displays_file($(this).data('path'));
        });
    };

    $('.optionImputation').change(function () {
        $('#tbl_affectation tbody').empty();
        $('.agent_col').removeClass('hide');
        $('.tp').removeClass('hide');
        switch ($(this).val()) {
            case '1':
                break;
            case '2':
                $('.agent_col').addClass('hide');
                break;
            case '3':
                $('.tp').addClass('hide');
                break;
            default:

                break;
        }
    });

    $(".btn_imputation").click(function () {
        var hide = '';
        var tp = '';
        var opt = $('input[name="optionImputation"]:checked').val();
        if (!$('#lst_instruction').val() > 0) {
            notify(lang.msg_data_imcomplet, "error");
            return 0;
        }
        switch (opt) {
            case '1':
                if (!$('#lst_personnel_courrier').val() > 0) {
                    notify(lang.msg_data_imcomplet, "error");
                    return 0;
                }
                if ($('#personnel_' + $('#lst_personnel_courrier').val()).length) {
                    notify(lang.msg_scode_desig_is_used, "error");
                    return 0;
                }
                if (!$('#lst_direction_service').val() > 0 || !$('#lst_instruction').val() > 0) {
                    notify(lang.msg_data_imcomplet, "error");
                    return 0;
                }
                break;
            case '2':
                hide = 'hide';
                if ($('#service_' + $('#lst_direction_service').val()).length) {
                    notify(lang.msg_scode_desig_is_used, "error");
                    return 0;
                }
                if (!$('#lst_direction_service').val() > 0 || !$('#lst_instruction').val() > 0) {
                    notify(lang.msg_data_imcomplet, "error");
                    return 0;
                }
                break;
            case '3':
                tp = 'hide';
                break;
            default:

                break;
        }

        var idDirection = $('#lst_direction_service').val();
        if($('#lst_direction_service option:selected').data('isdirection') == '1'){
           idDirection = $('#lst_direction_service option:selected').data('parent');
        }
        
        $('#tbl_affectation tbody').append(
                '<tr>' +
                '<td class="' + tp + '" id="service_' + $('#lst_direction_service').val() + '">' +
                '<input type="hidden" name="idDirection[]" value="' + idDirection + '" />'+
                '<input type="hidden" name="hierarchie[]" value="' + $('#lst_direction_service').val() + '" />' + $('#lst_direction_service option:selected').text() + '</td>' +
                '<td class="' + hide + ' ' + tp + '" id="personnel_' + $('#lst_personnel_courrier').val() + '"><input type="hidden" name="personnel[]" value="' + $('#lst_personnel_courrier').val() + '" />' + $('#lst_personnel_courrier option:selected').text() + '</td>' +
                '<td><input type="hidden" name="instruction[]" value="' + $('#lst_instruction').val() + '" />' + $('#lst_instruction option:selected').text() + '</td>' +
                '<td><input type="hidden" name="date_limit[]" value="' + $('#dp_date_limit_traiment').val() + '" />' + $('#dp_date_limit_traiment').val() + '</td>' +
                '<td><input type="hidden" name="remarque[]" value="' + $('#affectation_remarque').val() + '" />' + $('#affectation_remarque').val() + '</td>' +
                '<td class="text-center"><button onclick="tbl_remove_row(this)" type="button" class="btn btn-sm btn-warning"><i class="fa fa-times"></i></button></td>' +
                '</tr>');
    });


    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url') + '?id=' + $(this).data('id'), null, {id: $(this).data('id')});
    });

    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_110').click();
    });

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

    var handleDT = function () {
        datatable = $(table).DataTable({
            responsive: true,
            info: true,
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
                    d.id = $('#__id_courrier').val();
                }
            },
            order: [[1, 'asc']],
            columns: [
                {data: 'hierarchie', name: 'hierarchie'},
                {data: 'agent', name: 'agent'},
                {data: 'instruction', name: 'instruction'},
                {data: 'dateAffectation', name: 'dateAffectation'},
                {data: 'dateLimite', name: 'dateLimite'},
                {data: 'observation', name: 'observation'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            handleDeleteAffectation('.btn_del_affectation');
            KTMenu.init();
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-courrier-depart-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };

    var handleForm = function () {
        validator = FormValidation.formValidation(
                form,
                {
                    localization: mylocal.get(currentLanguage),
                    fields: {
                        'refExterne': {
                            validators: {
                                notEmpty: {
                                },
                                remote: {
                                    data: function () {
                                        return {expediteur: $('#lst_expediteur').val()};
                                    },
                                    message: lang.msg_scode_desig_is_used,
                                    method: 'GET',
                                    url: $(form).data('validate-reference-url')
                                }
                            }
                        },
                        'idExpediteur': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'idNature': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'dateArrive': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'dateCourrier': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'objet': {
                            validators: {
                                notEmpty: {
                                }
                            }
                        },
                        'refExterne': {
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

                    } else {
                        notify(lang.msg_data_imcomplet, "error");
                    }

                });
            }
        });
    };

    return {
        init: function () {
            table_fj = document.querySelector('#tbl_fichier_joint');
            table = document.querySelector('#dt_affectation');
            form = document.querySelector('#frm_courrier_new');
            submitButton = document.querySelector('#btn_new_courrier_submit');
            $('#frm_courrier_new .fselect2').select2({allowClear: true});
            $('#frm_courrier_new .mfselect2').select2({allowClear: true, minimumInputLength: 2});

            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
            $('.datetimepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                enableTime: true,
                altFormat: "d F Y H:i",
                dateFormat: "Y-m-d H:i",
            });
            handlePreview('#tbl_fichier_joint .preview');
            handleForm();
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSCourrier.init();
    KTMenu.init();
});