"use strict";

var datatable;
var table;
// Class definition

var KSencaissement = function () {
    $('.btn_new').click(function () {
        ks_load_view($(this).data('url'));
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
                }
            },
            order: [[1, 'asc']],
            columnDefs: [
                {
                    targets: [0, 6], // Index of the column to center (e.g., first column)
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
                {data: 'numvente', name: 'numvente'},
                {data: 'cli', name: 'cli'},
                {data: 'datevente', name: 'datevente'},
                {data: 'vendeur', name: 'vendeur'},
                {data: 'mnt', name: 'mnt'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
            KTMenu.init();
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
            table = document.querySelector('#dt_encaissement');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSencaissement.init();
});
