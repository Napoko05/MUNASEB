"use strict";

var datatable;
var table;
// Class definition

var KSSuivie = function () {
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
                    targets: [0, 13], // Index of the column to center (e.g., first column)
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
                {data: 'code', name: 'code'},
                {data: 'designation', name: 'designation'},
                {data: 'personneresp', name: 'personneresp'},
                {data: 'structureresp', name: 'structureresp'},
                {data: 'structurepartenaire', name: 'structurepartenaire'},
                {data: 'delaiexec', name: 'delaiexec'},
                {data: 'indicateur', name: 'indicateur'},
                {data: 'valeurindicateur', name: 'valeurindicateur'},
                {data: 'criticite', name: 'criticite'},
                {data: 'statut', name: 'statut'},
                {data: 'datedebut', name: 'datedebut'},
                {data: 'datefin', name: 'datefin'},
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
            table = document.querySelector('#dt_suivie');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTMenu.init();
    KSSuivie.init();
});
