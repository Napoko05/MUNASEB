"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;
var table, datatable, table_fj, tb_courrier_depart, dt_courrier_depart;

function prepend_option_nature(id, txt_option){
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
        filter_combo_by_data('#lst_personnel_courrier', 'data-direction', this);
        if(!$('.agent_col').hasClass('hide') && !$('#personnel_' + $('#lst_direction_service option:selected').attr('data-responsable')).length){
            $('#lst_personnel_courrier').select2('val', $('#lst_direction_service option:selected').attr('data-responsable'));
        }
    });
    
    var handlePreview = (m) => {
            $(m).click(function () {
                ks_displays_file($(this).data('path'));
            });
        };
    
    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url')+'?id='+ $(this).data('id'), null, {id: $(this).data('id')});
    });
    
    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_109').click();
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
                    d.id = $('#__id').val();
                }
            },
            columnDefs: [
                {
                    target: 6,
                    visible: false,
                    searchable: false
                }
            ],
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
            KTMenu.init();
        });
    };

    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-courrier-arrive-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };
    
    var dtCourrierarrive = function () {
         dt_courrier_depart = $(tb_courrier_depart).DataTable({
            responsive: true,
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_courrier_depart.on('draw', function () {
            KTMenu.init();
        });
    };
    return {
        init: function () {
            table_fj = document.querySelector('#tbl_fichier_joint');
            table =  document.querySelector('#dt_affectation');
            tb_courrier_depart =  document.querySelector('#dt_courrier_depart');
            form = document.querySelector('#frm_courrier_new');
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
            handleDT();
            handleSearchDatatable();
            dtCourrierarrive();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSCourrier.init();
    KTMenu.init();
});