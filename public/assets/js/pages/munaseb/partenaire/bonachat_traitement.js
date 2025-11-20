"use strict";

var KSMain = function () {
    var form;

    $(".btn_validate_num_adherant").click(function () {
        findBon();
    });

    $("#__Numbon").change(function () {
        findBon();
    });

    var findBon = function () {
        let numBon = $('#__Numbon').val();
        axios.get($(form).data('url-bonfinder'), {params: {numBon: numBon}})
                .then(response => {
                    KTApp.hidePageLoading();
                    switch (response.data.status) {
                        case 'success':
                            window.location = response.data.url;
                            break;
                        case 'fail':
                            notify('Numero bon introuvable ou invalide', "error");
                            break;
                        default:
                            notify('Adherant introuvable', "error");
                            break;
                    }
                })
                .catch(error => {
                    notify(error, "error");
                    KTApp.hidePageLoading();
                });

    };

    return {
        init: function () {
            form = document.querySelector('#frm_bonachat_new');
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KSMain.init();
});