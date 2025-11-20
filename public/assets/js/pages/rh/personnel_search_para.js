"use strict";

var KSearch = function () {
    var form;
    $('#___idDirection').change(function () {
        var parent = $(this).val();
        $('#___idService').val('').trigger('change');
        $('#___idService option').each(function () {
            if ($(this).data('parent') == parent) {
                $(this).prop('disabled', false);
            } else {
                 $(this).prop('disabled', true);
            }
        });
    });
    
    $('#btn_drawer_submit').click(function(){
        let opt = $('#drawer_optionsearch').val();
        switch (opt) {
            case 'pdf':
                ks_load_modal($('#personnel_search_para').data('export-url'), 'modal-xl', formDataToObject(new FormData(form)), '1');
                $('#btn_drawer_cancel').click();
                break;
            case 'excel': 
                let data = new FormData(form);
                let queryParams = new URLSearchParams(data).toString();
                window.location.href = $('#personnel_search_para').data('export-url') + '?' + queryParams;
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
            $('#koriss_left_drawer_frm .datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d"
            });
            $('#btn_drawer_submit').click();
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSearch.init();
});