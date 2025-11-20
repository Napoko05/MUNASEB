"use strict";

var KSearch = function () {
    var form;
    $('#btn_drawer_submit').click(function(){
        let opt = $('#drawer_optionsearch').val();
        switch (opt) {
            case 'pdf':
                ks_load_modal($('#adherant_search_para').data('export-url'), 'modal-xl', formDataToObject(new FormData(form)), '1');
                $('#btn_drawer_cancel').click();
                break;
            case 'excel': 
                let data = new FormData(form);
                let queryParams = new URLSearchParams(data).toString();
                window.location.href = $('#adherant_search_para').data('export-url') + '?' + queryParams;
                $('#btn_drawer_cancel').click();
                break;
            default:
                datatable.ajax.reload();
                $('#btn_drawer_cancel').click();
                break;
        }
    });
    return {
        init: function () {
            form = document.querySelector('#koriss_left_drawer_frm');
            $('#koriss_left_drawer_frm .fselect2').select2({allowClear:true});
            $('#koriss_left_drawer_frm .mfselect2').select2({minimumInputLength: 2});
            $('#koriss_left_drawer_frm .datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d"
            });
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSearch.init();
});