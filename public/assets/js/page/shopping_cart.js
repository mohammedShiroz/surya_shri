$(document).on('click', '.btn_cart_item_remove', function () {
    event.preventDefault();
    var product_row_id = $(this).attr("data-row-id");
    $.ajax({
        url: "/cart/remove-shopping-cart_item/" + product_row_id,
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            $('.cart_row_' + product_row_id).fadeOut(500, function () {
                $('#nav_update_cart_info').empty().html(data.nav_bar_view);
                $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
                swal("Item Removed!", data.item_name+" has been removed!", "success");
            });
        }
    });
});

$(document).on('click', '.delete_all_cart_items', function () {
    event.preventDefault();
    $.ajax({
        url: "/cart/remove-shopping-cart/all",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            $('.full_cart_show').fadeOut(500, function () {
                $('#nav_update_cart_info').empty().html(data.nav_bar_view);
                $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
                swal("Item Removed!", "Your wellness Basket has been cleared!", "success");
            });
        }
    });
});

$(document).on('click', '.plus_cart', function (event) {
    event.preventDefault();
    if ($(this).prev().val()) {
        $(this).prev().val(+$(this).prev().val() + 1);
    }
    var product_row_id = $(this).attr("data-row-id");
    var product_qty = $("#qty_" + product_row_id).val();
    $.ajax({
        url: "/cart/update_cart_qty/" + product_row_id + "/" + product_qty,
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            if(data == "invalid_stock"){
                swal("Stock Exceed", "Stock has been over reached!", "info");
                $("#qty_" + product_row_id).val((parseInt($("#qty_" + product_row_id).val())-1));
            }else{
                $('#nav_update_cart_info').empty().html(data.nav_bar_view);
                $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
            }
        }
    });
});

$(document).on('click', '.minus_cart', function (event) {
    event.preventDefault();
    if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
    }
    var product_row_id = $(this).attr("data-row-id");
    var product_qty = $("#qty_" + product_row_id).val();
    $.ajax({
        url: "/cart/update_cart_qty/" + product_row_id + "/" + product_qty,
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            $('#nav_update_cart_info').empty().html(data.nav_bar_view);
            $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
        }
    });
});


$(document).on('click', '.update_all_cart_items', function () {
    event.preventDefault();
    $.ajax({
        url: "/cart/update_cart/all",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function () {
            $(".update_all_cart_items").text("Updating...");
        },
        success: function (data) {
            setTimeout(function () {
                $('#nav_update_cart_info').empty().html(data.nav_bar_view);
                $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
                $(".update_all_cart_items").html("<i class=\"fa fa-check-square-o\"></i> Cart Updated");
                swal("Cart Updated!", "Your wellness basket has been updated!", "success");
            }, 1000);
        }
    });
});
