"use strict";

var datatable;
var table;
// Class definition

var KSBonachat = function () {
    $('.btn_left_drawer').click(function () {
        ks_load_drawer(this);
    });
    
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
                    var formData = $('#koriss_left_drawer_frm').serializeArray(); // Get form data
                    $.each(formData, function (key, value) {
                        d[value.name] = value.value; // Append form fields to AJAX data
                    });
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
                    targets: [0], // Index of the column to center (e.g., first column)
                    className: 'text-center'
                },
                {
                    targets: [7], // Index of the column to center (e.g., first column)
                    className: 'text-end'
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
                {data: 'numBon', name: 'numBon'},
                {data: 'nature', name: 'nature'},
                {data: 'partenaire', name: 'partenaire'},
                {data: 'datebon', name: 'datebon'},
                {data: 'observation', name: 'observation'},
                {data: 'designationAction', name: 'designationAction'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        datatable.on('draw', function () {
        });
    };
    
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[dt-bon-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    };
    
    // Public methods
    return {
        init: function () {
            table = document.querySelector('#dt_bonachat');
            handleDT();
            handleSearchDatatable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KSBonachat.init();
});
