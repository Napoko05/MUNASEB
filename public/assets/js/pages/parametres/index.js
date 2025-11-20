"use strict";

var dt_n;
var dt_pa;
var dt_r;
var dt_p;
var dt_c;
var dt_v;

// Class definition

function ajax_reload_page() {
    $($('#kt_app_content').data('menu-id')).click();
}

var KSSetting = function () {
    // Define shared variables
    var table_nationalite;
    var table_pays;
    var table_region;
    var table_province;
    var table_commune;
    var table_ville;

    var list = function () {
        $('.btn_new').click(function () {
            ks_load_modal($(this).data('url'), 'modal-md', {callback: $(this).data('callback')}, '1', );
        });
        
        var handleEdit = (m) => {
            $(m).click(function () {
                ks_load_modal($(this).data('edit-url'), 'modal-md', {id: $(this).data('id')}, '1');
            });
        };
        
        var handleStatut = (m) => {
            $(m).click(function () {
                var id = $(this).data('id');
                var statut = $(this).data('statut');
                var url = $(this).data('statut-url');
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
                        axios.post(url, {id: id, statut: statut})
                                .then(response => {
                                    KTApp.hidePageLoading();
                                    switch (response.data.status) {
                                        case 'success':
                                            notify(lang.msg_save_succes, "success");
                                            $($('#kt_app_content').data('menu-id')).click();
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
        
        dt_n = $(table_nationalite).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_n.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_nationalite .edit_row');
            handleStatut('#dt_list_nationalite .status_row');
        });
        
        dt_r = $(table_region).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_r.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_list_region .status_row');
        });
        
        dt_p = $(table_province).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_p.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_list_province .status_row');
        });
        
        dt_c = $(table_commune).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_c.on('draw', function () {
            KTMenu.init();
            handleStatut('#dt_list_commune .status_row');
        });
        
        dt_v = $(table_ville).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_v.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_ville .edit_row');
            handleStatut('#dt_list_ville .status_row');
        });
        
        dt_pa = $(table_pays).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                {orderable: false, targets: 0}
            ]
        });
        dt_pa.on('draw', function () {
            KTMenu.init();
            handleEdit('#dt_list_pays .edit_row');
            handleStatut('#dt_list_pays .status_row');
        });
    };


    var handleSearchDatatable = () => {
        const filterSearch_1 = document.querySelector('[dt-menu-filter-nationalite="search"]');
        filterSearch_1.addEventListener('keyup', function (e) {
            dt_n.search(e.target.value).draw();
        });
        
        const filterSearch_2 = document.querySelector('[dt-menu-filter-pays="search"]');
        filterSearch_2.addEventListener('keyup', function (e) {
            dt_pa.search(e.target.value).draw();
        });
        
        const filterSearch_3 = document.querySelector('[dt-menu-filter-region="search"]');
        filterSearch_3.addEventListener('keyup', function (e) {
            dt_r.search(e.target.value).draw();
        });
        
        const filterSearch_4 = document.querySelector('[dt-menu-filter-province="search"]');
        filterSearch_4.addEventListener('keyup', function (e) {
            dt_p.search(e.target.value).draw();
        });
        
        const filterSearch_5 = document.querySelector('[dt-menu-filter-commune="search"]');
        filterSearch_5.addEventListener('keyup', function (e) {
            dt_c.search(e.target.value).draw();
        });
        
        const filterSearch_6 = document.querySelector('[dt-menu-filter-ville="search"]');
        filterSearch_6.addEventListener('keyup', function (e) {
            dt_v.search(e.target.value).draw();
        });
    };

    // Public methods
    return {
        init: function () {
            table_nationalite = document.querySelector('#dt_list_nationalite');
            table_region = document.querySelector('#dt_list_region');
            table_province = document.querySelector('#dt_list_province');
            table_commune = document.querySelector('#dt_list_commune');
            table_ville = document.querySelector('#dt_list_ville');
            table_pays = document.querySelector('#dt_list_pays');
            list();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSSetting.init();
});
