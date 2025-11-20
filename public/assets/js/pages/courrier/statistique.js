"use strict";
// Class definition

var KSCourrier = function () {
    $('#lst_type_structure').change(function () {
        ks_load_view($(this).data('url'), null, {type_agence: $(this).val()});
    });
    
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
});
