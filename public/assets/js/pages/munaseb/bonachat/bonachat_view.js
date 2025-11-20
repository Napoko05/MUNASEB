"use strict";
var mylocal = new Map([['fr', FormValidation.locales.fr_FR], ['en', FormValidation.locales.en_US], ['ar', FormValidation.locales.ar_MA]]);
var validator;

var KSMain = function () {
    var form;
    $("#btn_new_bonachat_cancel").click(function () {
        $('#menu_item_40').click();
    });

    $('.btn-refresh-right').click(function () {
        ks_load_view($(this).data('url'));
    });

    $("#btn_new_courrier_cancel").click(function () {
        $('#menu_item_40').click();
    });

    var handlePreview = (m) => {
        $(m).click(function () {
            ks_displays_file($(this).data('path'));
        });
    };

    return {
        init: function () {
            form = document.querySelector('#frm_bonachat_new');

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
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
    KTMenu.init();
});