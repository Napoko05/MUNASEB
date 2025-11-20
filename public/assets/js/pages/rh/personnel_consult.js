"use strict";
var table_fj;
var dt_fj;

var KSPara = function () {
    var form;

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'), null, {id: $(this).data('id')});
    });
    
    $("#btn_new_personne_cancel").click(function () {
        $('#menu_item_19').click();
    });

    var handlePreview = (m) => {
            $(m).click(function () {
                ks_displays_file($(this).data('path'));
            });
        };

    var handleSearchFichier = () => {
        const filterSearch = document.querySelector('[dt-menu-filter-fj="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt_fj.search(e.target.value).draw();
        });
    };
    
    return {
        init: function () {
            form = document.querySelector('#frm_personnel_new');
            table_fj = document.querySelector('#dt_fichier_joint');
            dt_fj = $(table_fj).DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
                'columnDefs': [
                    {orderable: false, targets: 0}
                ]
            });
            dt_fj.on('draw', function () {
                KTMenu.init();
                handleSearchFichier();
                handlePreview('#dt_fichier_joint .preview');
            });
            $('.datepicker').flatpickr({
                locale: currentLanguage,
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            });
        }
    };
}();
// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSPara.init();
});