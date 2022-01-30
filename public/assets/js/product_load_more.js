/*===================================
Author       : Bestwebcreator.
Template Name: Shopwise - eCommerce Bootstrap 4 HTML Template
Version      : 1.0
===================================*/

var $container = $(".loadmore");
if ($container.length > 0) {
    if ($container.hasClass("masonry")) {
        $container.isotope({
            itemSelector: '.grid_item',
            percentPosition: true,
            layoutMode: "masonry",
            masonry: {
                columnWidth: '.grid-sizer'
            },
        });
    }
    else {
        $container.isotope({
            itemSelector: '.grid_item',
            percentPosition: true,
            layoutMode: "fitRows",
        });
    }
}

//****************************
// Isotope Load more button
//****************************
var initShow = $('.loadmore').data('item'); //number of items loaded on init & onclick load more button
var counter = initShow; //counter for load more button
var iso = $container.data('isotope'); // get Isotope instance
var btn_text = $container.data('btn');

loadMore(initShow);
function loadMore(toShow) {
    $container.find(".grid_item.grid_item_hide").removeClass("grid_item_hide");

    var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function (item) {
        return item.element;
    });
    $(hiddenElems).addClass('grid_item_hide');

    $container.isotope('layout');


    //when no more to load, hide show more button
    if (hiddenElems.length == 0) {
        jQuery(".load_more_wrap #load-more").hide();
        var message = $('.loadmore').data('finish-message');
        $('.load_more_wrap').append("<span class='alert alert-info hide_msg'>" + message + "</span>");
    } else {
        jQuery(".load_more_wrap #load-more").show();
        $('.hide_msg').hide();
    }
    ;
}

//append load more button
$container.after("<div class='text-center load_more_wrap'><button id='load-more' class='btn btn-fill-out'>" + btn_text + "</button></div>");
var select_status=0;
$("#show_filter").change(function () {
    select_status=1;
    var show = $(this).val();
    $("#load-more").addClass('loading');
    setTimeout(function () {
        loadMore(0);
        $('#load-more').removeClass('loading');
        loadMore(show);
    }, 800);
});

//when load more button clicked
$("#load-more").click(function () {
    var show = $('.loadmore').data('item-show');
    var get_show_count = $('#show_filter').val();
    if(select_status != 0){
        counter=parseInt(get_show_count);
        select_status=0;
    }

    counter = (counter + show);
    $('#show_filter').val(counter);
    $("#load-more").addClass('loading');
    setTimeout(function () {
        $('#load-more').removeClass('loading');

        loadMore(counter);
    }, 800);
});