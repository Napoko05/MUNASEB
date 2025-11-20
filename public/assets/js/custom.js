// JavaScript Document
var skipreadyfunction = false;
jQuery(document).ready(function ($) {
    //Put Your Custom Jquery or Javascript Code Here
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
});

function ks_load_drawer(me) {
    var url = $(me).data('url');
    if ($(me).data('loaded') == false) {
        KTApp.showPageLoading();
        axios.get(url).then(function (response) {
            $("#koriss_left_drawer").attr('data-kt-drawer-width', "{default:'300px', 'md': '800px'}");
            var drawer = KTDrawer.getInstance(document.querySelector("#koriss_left_drawer"));
            drawer.update();
            $("#koriss_left_drawer_body").empty().append(response.data);
            drawer.toggle();
            $(me).data('loaded', true);
        }).catch(function (error) {
            notify(error, "error");
        }).finally(function () {
            setTimeout(function () {
                KTApp.hidePageLoading();
            }, 100);
        });
    } else {
        var drawer = KTDrawer.getInstance(document.querySelector("#koriss_left_drawer"));
        drawer.toggle();
    }
}

function ks_load_modal(url, size_sm, _data, _level) {
    // size_sm: modal-md, modal-sm, modal-lg, modal-xl,mw-650px ...
    var level = (typeof level == 'undefined') ? 1 : _level;
    try {
        if (typeof size_sm == 'undefined') {
            $("#modal_contenair_" + level).removeClass($("#modal_contenair_" + level).data('size'));
            $("#modal_contenair_" + level).addClass(size_sm).data('size', '');
        } else {
            $("#modal_contenair_" + level).removeClass($("#modal_contenair_" + level).data('size'));
            $("#modal_contenair_" + level).addClass(size_sm).data('size', size_sm);
        }
        KTApp.showPageLoading();
        axios.get(url, {params: _data}).then(function (response) {
            $("#modal_contenair_" + level).empty().append(response.data);
            $("#modal_level_" + level).modal("show");
        }).catch(function (error) {
            notify(error, "error");
        }).finally(function () {
            setTimeout(function () {
                KTApp.hidePageLoading();
            }, 100);
        });
    } catch (err) {
        notify(err, "error");
    }
}

function ks_menu_load_view(url, me, data) {
    $("#koriss_left_drawer_body").empty();
    ks_load_view(url, me, data);
}

function ks_load_view(url, me, data) {
    KTApp.showPageLoading();
    axios.get(url, {params: data}).then(function (response) {
        if (typeof me != 'undefined' && me != null) {
            $('.menu-item').removeClass('menu-active');
            $(me).parent().addClass('menu-active');
        }
        history.pushState(null, '', url);
        $("#kt_app_form_contenair").empty().append(response.data);
    }).catch(function (error) {
        notify(error, "error");
    }).finally(function () {
        setTimeout(function () {
            KTApp.hidePageLoading();
        }, 100);
    });
}

function ks_load_image_resizer(form_id, preview_contenair, crop_width, crop_height, crop_resizable, aspect_ration, _level) {
    var level = (typeof level == 'undefined') ? 1 : _level;
    try {
        $("#modal_contenair_" + level).removeClass($("#modal_contenair_" + level).data('size'));
        $("#modal_contenair_" + level).addClass('modal-lg').data('size', 'modal-lg');
        KTApp.showPageLoading();
        axios.get(base_url + '/img_resizer', {
            params: {
                form_id: form_id,
                preview_contenair: preview_contenair,
                crop_width: crop_width,
                crop_height: crop_height,
                crop_resizable: crop_resizable,
                aspect_ration: aspect_ration
            }
        }).then(function (response) {
            $("#modal_contenair_" + level).empty().append(response.data);
            $("#modal_level_" + level).modal("show");
        }).catch(function (error) {
            notify(error, "error");
        }).finally(function () {
            setTimeout(function () {
                KTApp.hidePageLoading();
            }, 100);
        });
    } catch (err) {
        notify(err, "error");
    }
}

function ks_displays_file($path) {
    var fileExtension = $path.split('.').pop().toLowerCase();
    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'ico', 'pdf'].includes(fileExtension)) {
        ks_load_modal(url_preview_file, 'modal-xl', {path: $path}, '1');
    } else {
        ks_download_file($path);
    }

}

function ks_download_file(path) {
    const a = document.createElement('a');
    a.href = path;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

String.prototype.escapeSpecialChars = function () {
    return this.replace(/\\n/g, "\\n")
            .replace(/\\'/g, "\\'")
            .replace(/\\"/g, '\\"')
            .replace(/\\&/g, "\\&")
            .replace(/\\r/g, "\\r")
            .replace(/\\t/g, "\\t")
            .replace(/\\b/g, "\\b")
            .replace(/\\f/g, "\\f");
};

function isjson(data) {
    try {
        var json = eval('(' + data + ')');
        return json;
    } catch (e)
    {
        return false;
    }
}

function msgbox(msg, title, type) {
    // type : error, warning, info
    type_icon = (typeof type == 'undefined') ? "info" : type;
    title_m = (typeof title == 'undefined') ? "YENENGA" : title;

    sweetAlert(title_m, msg, type_icon);
}

function confirmbox(conf_fct, msg, title, type) {
    try {
        msg = (typeof msg == 'undefined' || msg == null) ? "" : msg;
        type_icon = (typeof type == 'undefined') ? "warning" : type;
        title_m = (typeof title == 'undefined' || title == null) ? "Votre Confirmation !!!?" : title;
        swal({
            title: title_m,
            text: msg,
            type: type_icon,
            focusConfirm: false,
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Continuer",
            cancelButtonText: "Annuler",
            closeOnConfirm: true
        },
                function () {
                    $(".sweet-alert button").addClass('hide');
                    $(".sweet-alert").find('h2').addClass('hide');
                    $(".sweet-alert").append("<div id='_sweet_loadding' class='sweet-loadding'></div>");
                    $("#_hidden_confirm").trigger("click");
                });
        if ($("#_hidden_confirm").length) {
            $("#_sweet_loadding, #_hidden_confirm").remove();
            $(".sweet-alert").find('h2').removeClass('hide');
            $(".sweet-alert button").removeClass('hide');
        }

        $(".sweet-alert").append("<button class='btn_action' onclick=" + conf_fct + " style='display:none;' id='_hidden_confirm'>dff</button>");
    } catch (err) {

    }
}

function set_fname(me) {
    var tr = $(me).parents('tr');
    $(tr).find('.fname').val($(me)[0].files[0].name);
}

function tbl_remove_row_with_validator(me) {
    $(me).parents('tr').find('.fv-row input').each(function () {
        validator.removeField($(this).attr('name'));
    });
    $(me).parents('tr').remove();
}

function set_fname_by_selector(selector, fname) {
    $(selector).attr('name', fname);
}

function tbl_remove_row(me) {
    $(me).parents('tr').remove();
}

function tbl_total_row(me, x, t) {
    var tr = $(me).parents('tr');
    var q = accounting.unformat($(me).val());
    var y = accounting.unformat($(tr).find(x).val());
    var z = q*y;
    $(tr).find(t).val(accounting.formatNumber(z));
}

function tbl_total_tbody(t, x) {
    var total = 0;
    $(t).find(x).each(function () {
        total += accounting.unformat($(this).val());
    });
    return total;
}

function notify(message, type, title) {
    try {
        if (title == null || (typeof title == 'undefined')) {
            title = "YENENGA";
        }

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-left",
            timeOut: 5000
        };

        if (toastr[type]) {
            toastr[type](message, title);
        } else {
            toastr.info(message, title);
        }
    } catch (err) {

    }
}

function date_diff(dd, df) {
    var a1 = dd.split("/");
    var d1 = new Date(a1[1] + '/' + a1[0] + '/' + a1[2]);
    a2 = df.split("/");
    var d2 = new Date(a2[1] + '/' + a2[0] + '/' + a2[2]);
    var timediff = Math.abs(d2.getTime() - d1.getTime());
    n = Math.ceil(timediff / (1000 * 3600 * 24));
    if (isNaN(n)) {
        n = 0;
    }
    return n;
}

function dateCompare(date1, date2, or_equal) {
    var d1 = date1;
    var d2 = date2;
    var a1 = d1.split("/");
    if (a1.length < 3) {
        return false;
    }
    var d11 = new Date(a1[2], a1[1], a1[0]);
    var a2 = d2.split("/");
    if (a2.length < 3) {
        return false;
    }
    var d22 = new Date(a2[2], a2[1], a2[0]);
    if (typeof (or_equal) === "undefined") {
        return d22 > d11;
    } else {
        return  d22 >= d11;
    }

}

function date_format(date_or, from = "db", to = "fr") {
    if (!date_or)
        return "";

    const pad = (n) => String(n).padStart(2, '0');

    const formatDate = (date, format) => {
        const dd = pad(date.getDate());
        const mm = pad(date.getMonth() + 1);
        const yyyy = date.getFullYear();

        switch (format) {
            case "db":
                return `${yyyy}-${mm}-${dd}`;
            case "en":
            case "mm/dd/yyyy":
                return `${mm}/${dd}/${yyyy}`;
            case "fr":
            case "dd/mm/yyyy":
            default:
                return `${dd}/${mm}/${yyyy}`;
        }
    };

    const today = new Date();

    if (["lastday", "lastdayofmonth"].includes(date_or)) {
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        return formatDate(lastDay, from);
    }

    if (["firstday", "firstdayofmonth"].includes(date_or)) {
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        return formatDate(firstDay, from);
    }

    if (date_or === "today") {
        return formatDate(today, from);
    }

    // Convert actual date strings (e.g., "2025-05-26")
    if (from === "db") {
        const parts = date_or.split("-");
        if (parts.length !== 3)
            return "";
        const [yyyy, mm, dd] = parts;
        const parsedDate = new Date(`${yyyy}-${mm}-${dd}`);
        return formatDate(parsedDate, to);
    }

    return "";
}

function addDays(date, days, format = 'fr') {
    const result = new Date(date);
    result.setDate(result.getDate() + days);

    const year = result.getFullYear();
    const month = String(result.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const day = String(result.getDate()).padStart(2, '0');

    if (format == 'fr') {
        return `${day}/${month}/${year}`;
    } else {
        return `${year}-${month}-${day}`;
}
}

function date_format_from_to(date, from, to) {
    var ___date = '';
    date = date + '';
    from = (typeof (from) === "undefined") ? "db" : from.toLowerCase();
    if (typeof (to) === "undefined") {
        if (date.length > 10) {
            to = formatdate.toLowerCase() + ' hh:ii';
        } else {
            to = formatdate.toLowerCase();
        }
    }

    if (date == '' || date == null || date.length < 8) {
        return '';
    }

    date = date.replaceAll('/', '-');
    date = date.replaceAll('.', '-');
    from = from.replaceAll('/', '-');
    from = from.replaceAll('.', '-');

    if (date == '0000-00-00' || date == '0000-00-00 00:00:00' || date == '00-00-0000' || date == '00-00-0000 00:00:00') {
        return '';
    }

    var dd = '';
    var mm = '';
    var yyyy = '';
    var hh = '';
    var ii = '';

    switch (from) {
        case 'yyyy-mm-dd':
        case 'yyyy-mm-dd hh:ii':
        case 'yyyy-mm-dd hh:ii:ss':
        case 'db':
            if (date.length <= 10) {
                var arFrom = date.split("-");
                yyyy = arFrom[0];
                mm = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
                dd = (arFrom[2].length < 2) ? '0' + arFrom[2] : arFrom[2];
            } else {
                var date_sp = date.split(" ");
                var arFrom = date_sp[0].split('-');
                var heure = date_sp[1].split(':');

                yyyy = arFrom[0];
                mm = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
                dd = (arFrom[2].length < 2) ? '0' + arFrom[2] : arFrom[2];
                hh = (heure[0].length < 2) ? '0' + heure[0] : heure[0];
                ii = (heure[1].length < 2) ? '0' + heure[1] : heure[1];
            }
            break;
        case 'yyyy-dd-mm':
        case 'yyyy-dd-mm hh:ii':
        case 'yyyy-dd-mm hh:ii:ss':
            if (date.length <= 10) {
                var arFrom = date.split("-");
                yyyy = arFrom[0];
                mm = (arFrom[2].length < 2) ? '0' + arFrom[2] : arFrom[2];
                dd = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
            } else {
                var date_sp = date.split(" ");
                var arFrom = date_sp[0].split('-');
                var heure = date_sp[1].split(':');

                yyyy = arFrom[0];
                mm = (arFrom[2].length < 2) ? '0' + arFrom[2] : arFrom[2];
                dd = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
                hh = (heure[0].length < 2) ? '0' + heure[0] : heure[0];
                ii = (heure[1].length < 2) ? '0' + heure[1] : heure[1];
            }
            break;
        case 'fr':
        case 'dd-mm-yyyy':
        case 'dd-mm-yyyy hh:ii':
        case 'dd-mm-yyyy hh:ii:ss':
            if (date.length <= 10) {
                var arFrom = date.split("-");
                yyyy = arFrom[2];
                mm = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
                dd = (arFrom[0].length < 2) ? '0' + arFrom[0] : arFrom[0];
            } else {
                var date_sp = date.split(" ");
                var arFrom = date_sp[0].split('-');
                var heure = date_sp[1].split(':');

                yyyy = arFrom[2];
                mm = (arFrom[1].length < 2) ? '0' + arFrom[1] : arFrom[1];
                dd = (arFrom[0].length < 2) ? '0' + arFrom[0] : arFrom[0];
                hh = (heure[0].length < 2) ? '0' + heure[0] : heure[0];
                ii = (heure[1].length < 2) ? '0' + heure[1] : heure[1];
            }
            break;
        case 'date':
            var _date = new Date(date);
            yyyy = _date.getFullYear();
            mm = ("0" + (_date.getMonth() + 1)).slice(-2);
            dd = ("0" + _date.getDate()).slice(-2);
            hh = ("0" + _date.getHours()).slice(-2);
            ii = ("0" + _date.getMinutes()).slice(-2);
            break;
        default:

            break;
    }

    var separator = '/';

    if (to.indexOf('.') > -1) {
        separator = '.';
    } else if (to.indexOf('-') > -1) {
        separator = '-';
    } else if (to == 'db') {
        separator = '-';
        if (date.length <= 10) {
            to = 'yyyy-mm-dd';
        } else {
            to = 'yyyy-mm-dd hh:ii';
        }
    }

    var heure = '';
    if (hh != '' && ii != '') {
        heure = ' ' + hh + ':' + ii;
    }

    switch (to) {
        case 'fr':
        case 'dd/mm/yyyy':
        case 'dd/mm/yyyy hh:ii':
        case 'dd/mm/yyyy hh:ii:ss' :
        case 'dd.mm.yyyy':
        case 'dd.mm.yyyy hh:ii':
        case 'dd.mm.yyyy hh:ii:ss':
        case 'dd-mm-yyyy':
        case 'dd-mm-yyyy hh:ii':
        case 'dd-mm-yyyy hh:ii:ss':
            if (to.length <= 10) {
                ___date = dd + separator + mm + separator + yyyy;
            } else {
                ___date = dd + separator + mm + separator + yyyy + heure;
            }
            break;
        case 'db':
        case 'yyyy/mm/dd':
        case 'yyyy/mm/dd hh:ii':
        case 'yyyy/mm/dd hh:ii:ss':
        case 'yyyy.mm.dd':
        case 'yyyy.mm.dd hh:ii':
        case 'yyyy.mm.dd hh:ii:ss':
        case 'yyyy-mm-dd':
        case 'yyyy-mm-dd hh:ii':
        case 'yyyy-mm-dd hh:ii:ss':
            if (to.length <= 10) {
                ___date = yyyy + separator + mm + separator + dd;
            } else {
                ___date = yyyy + separator + mm + separator + dd + heure;
            }
            break;
        case 'yyyy/dd/mm':
        case 'yyyy/dd/mm hh:ii':
        case 'yyyy/dd/mm hh:ii:ss':
        case 'yyyy.dd.mm':
        case 'yyyy.dd.mm hh:ii':
        case 'yyyy.dd.mm hh:ii:ss':
        case 'yyyy-dd-mm':
        case 'yyyy-dd-mm hh:ii':
        case 'yyyy-dd-mm hh:ii:ss':
            if (to.length <= 10) {
                ___date = yyyy + separator + dd + separator + mm;
            } else {
                ___date = yyyy + separator + dd + separator + mm + heure;
            }
            break;
        case 'mm/dd/yyyy':
        case 'mm/dd/yyyy hh:ii':
        case 'mm/dd/yyyy hh:ii:ss':
        case 'mm.dd.yyyy':
        case 'mm.dd.yyyy hh:ii':
        case 'mm.dd.yyyy hh:ii:ss':
        case 'mm-dd-yyyy':
        case 'mm-dd-yyyy hh:ii':
        case 'mm-dd-yyyy hh:ii:ss':
            if (to.length <= 10) {
                ___date = mm + separator + dd + separator + yyyy;
            } else {
                ___date = mm + separator + dd + separator + yyyy + heure;
            }
            break;
        default:

            break;
    }
    return ___date;
}

function date_hour_formatter(value) {
    let date = new Date(value);
    let dateStr =
            date.getFullYear() + "-" +
            ("00" + (date.getMonth() + 1)).slice(-2) + "-" +
            ("00" + date.getDate()).slice(-2) + " " +
            ("00" + date.getHours()).slice(-2) + ":" +
            ("00" + date.getMinutes()).slice(-2);
    // ("00" + date.getSeconds()).slice(-2);
    return dateStr;
}

function set_wysiwyg_value(target, content) {
    a = $("#" + target).data("wysihtml5");
    b = a.editor;
    b.setValue(content);
}

function rtrim(str, ch) {
    str = $.trim(str);
    if (str.substr(str.length - 1) == ch) {
        str = str.substr(0, str.length - 1);
    }
    return str;
}

function ltrim(str, ch) {
    str = $.trim(str);
    if (str.substr(0, 1) == ch) {
        str = str.substr(1, str.length);
    }
    return str;
}

function trim(str, ch) {
    str = rtrim(str, ch);
    return ltrim(str, ch);
}

function is_valid_email(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function get_file_ext(fname) {
    n = fname.indexOf('.');
    return fname.substring(n);
}

function remove_readonly(me) {
    if ($(me).is(':checked')) {
        $(me).parents('div').find('input').prop('readonly', false);
    } else {
        $(me).parents('div').find('input').prop('readonly', true);
    }
}

function formDataToObject(formData) {
    const formObject = {};

    formData.forEach((value, key) => {
        if (formObject[key]) {
            formObject[key] = [].concat(formObject[key], value);
        } else {
            formObject[key] = value;
        }
    });

    return formObject;
}

function filter_combo_by_data(selector, data, target) {
    var dir = $(target).val();
    $(selector).select2('val', '');
    $(selector).find('option').each(function () {
        if ($(this).attr(data) == dir) {
            $(this).prop('disabled', false);
        } else {
            $(this).prop('disabled', true);
        }
    });
}

function prepend_option(selector, id, txt) {
    var newOption = new Option(txt, id, true, true);
    $(selector).append(newOption).trigger('change');
}

function init_datatable(tname, search) {
    var dt = $(tname).DataTable({
        "responsive": true,
        "info": false,
        'order': [],
        'pageLength': 10,
        'columnDefs': [
            {orderable: false, targets: 0}
        ]
    });
    dt.on('draw', function () {
        KTMenu.init();
    });
    const filterSearch = document.querySelector('[' + search + '="search"]');
    filterSearch.addEventListener('keyup', function (e) {
        dt.search(e.target.value).draw();
    });
}