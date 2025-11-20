// JavaScript Document
jQuery(document).ready(function ($) {
    pos_resize_screen();
});


function pos_resize_screen(option = 'window'){
    var contenair_height = $(window).height() - 114;
    if(option != 'window'){
        contenair_height = $(document).height() - 100;
    }
    var size_content_height = contenair_height-20;
    var prod_content_height = size_content_height - 340;
    var grid_content_height = size_content_height -100;
    $('#pos_container').css('height',contenair_height+'px');
    $('.left-content, .right-content').css('height', size_content_height+'px');
    $('#pos_produit_vendu').css('height',prod_content_height+'px');
    $('.grid').css('height',grid_content_height+'px');
}


