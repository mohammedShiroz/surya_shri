$(document).on('click', '.add_to_cart', function(){
    var product_id = $(this).attr("data-product-id");
    var product_quantity = $('.pro_quantity_'+product_id).val();
    //alert(product_id+ " - "+ product_quantity);
    $.ajax({
        url:"/cart/add_item?product_id="+product_id+"&product_qty="+product_quantity,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data)
        {
            if(data == "invalid_stock") {
                swal("Stock Exceed", "Stock has been over reached!", "info");
            }else{
                //: Change the button style
                $(this).addClass("clicked");
                setTimeout(function () {
                    $(".btn_cart_added_"+product_id).removeClass("clicked");
                    $(".btn_cart_added_"+product_id).addClass("un_clicked");
                    setTimeout(function () {
                        $(".btn_cart_added_"+product_id).removeClass("un_clicked");
                    }, 1500);
                }, 500);

                var cart_icon = $('.shake_icon');
                var imgtodrag = $('.img_cart'+product_id).eq(0);
                //$(this).parent('.item').find("img").eq(0);
                if (imgtodrag) {
                    var imgclone = imgtodrag.clone()
                        .offset({
                            top: imgtodrag.offset().top,
                            left: imgtodrag.offset().left
                        })
                        .css({
                            'opacity': '0.5',
                            'position': 'absolute',
                            'height': '150px',
                            'width': '150px',
                            'z-index': '10000',
                            'border-radius':'10%'
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart_icon.offset().top + 10,
                            'left': cart_icon.offset().left + 10,
                            'width': 75,
                            'height': 75
                        }, 1000, 'easeInOutExpo');

                    setTimeout(function () {
                        $(".linearicons-cart").effect( "shake", {times:2}, 200 );
                    }, 1500);
                    imgclone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        $(this).detach()
                    });
                }
                $('#nav_update_cart_info').empty().html(data);
            }
            //alert(data);
        }
    });
});

$(document).on('click', '.btn_cart_del', function(){
    event.preventDefault();
    var product_row_id = $(this).attr("data-row-id");
    $.ajax({
        url:"/cart/remove_item/"+product_row_id,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data)
        {
            $('#nav_update_cart_info').empty().html(data.cart_view);
            $('#fetch_shopping_cart_data').empty().html(data.shopping_cart_view);
            swal("Item Removed!", data.item_name+" Item has been removed!", "success");
        }
    });
});

$(document).on('click', '.add-to-wish-list', function(event){
    event.preventDefault();
    var product_id=$(this).attr("data-product-id");
    if(product_id !="invalid_id"){
        $.ajax({
            url:"/wish-list/add-item",
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{ id:product_id},
            success: function (data) {
                if(data.status == 'add'){
                    $(".btn_wish_cart_"+product_id).addClass("clicked");
                    swal("Success", "Product has been added to Wishlist!", "success");
                }else{
                    $(".btn_wish_cart_"+product_id).removeClass("clicked");
                    swal("Success", "Product has been removed from Wishlist!", "success");
                }
                $('#wish-list-products-count').html(data.count);
            }
        });
    }else{
        swal({
            title: "Hi!",
            text: "Looks like you aren’t logged in. Please login to add products to your wish-list.",
            type: "info",
            icon:"info"
        }).then(function() {
            window.location = "/login";
        });
    }
});

$(document).on('click', '.wish_list_remove_product_btn', function(event){
    event.preventDefault();
    var product_id=$(this).attr("data-product-id");
    swal({
        title: "NOTICE",
        text: "Are you sure want to remove this product from your wishlist?",
        icon: "warning",
        buttons: ["Cancel", "Confirm"],
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:"/wish-list/remove-item/"+product_id,
                method: "POST",
                data:{},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $('#pro_view_'+product_id).fadeOut();
                    $('#wish-list-products-count').html(data.count);
                    $(".filter_data").empty().html(data.items_view);
                    swal("Success! Product has been removed!", {
                        icon: "success",
                    });
                }
            });
        } else { }
    });
});

$(document).on('click', '#clear_all_wish_list_items', function(event){
    event.preventDefault();
    swal({
        title: "Clear All?",
        text: "Are you sure want to clear all wishlist products and services?",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:"/wish-list/remove-all-wishList",
                    method: "POST",
                    data:{},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        $('#wish-list-products-count').html(data.count);
                        $(".filter_data").empty().html(data.items_view);
                        swal("Success! Your wishlist has been cleared!", {
                            icon: "success",
                        });
                    }
                });
            } else { }
        });
});


$(document).on('click', '.btn-add-fav', function(event){
    event.preventDefault();
    var service_id=$(this).attr("data-service-id");
    if(service_id !="invalid_id"){
            $.ajax({
                url:"/wish-list/add-service",
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{ id:service_id},
                success: function (data) {
                    $(".btn-add-fav").hide();
                    $(".btn-rm-fav").show();
                    $('#wish-list-products-count').html(data.count);
                    swal("Success", "Service has been added to Wishlist!", "success");
                }
            });
    }else{
        swal({
            title: "Hi!",
            text: "Looks like you aren’t logged in. Please login to add service to your favorites list.",
            type: "info",
            icon:"info"
        }).then(function() {
            window.location = "/login";
        });
    }
});

$(document).on('click', '.btn-rm-fav', function(event){
    event.preventDefault();
    var service_id=$(this).attr("data-service-id");
    if(service_id !="invalid_id"){
        $.ajax({
            url:"/wish-list/remove-service/"+service_id,
            method: "POST",
            data:{},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $(".btn-rm-fav").hide();
                $(".btn-add-fav").show();
                $('#wish-list-products-count').html(data.count);
                $(".filter_data").empty().html(data.items_view);
                swal("Success", "Service has been removed from Wishlist!", "success");
            }
        });
    }else{
        swal({
            title: "Hi!",
            text: "Looks like you aren’t logged in. Please login to add service to your favorites list.",
            type: "info",
            icon:"info"
        }).then(function() {
            window.location = "/login";
        });
    }
});

$(document).on('click', '.wish_list_remove_service_btn', function(event){
    event.preventDefault();
    var service_id=$(this).attr("data-service-id");
    swal({
        title: "NOTICE",
        text: "Are you sure want to remove this service from your wishlist?",
        icon: "warning",
        buttons: ["Cancel", "Confirm"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:"/wish-list/remove-service/"+service_id,
                    method: "POST",
                    data:{},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        $('#service_view_'+service_id).fadeOut();
                        $('#wish-list-products-count').html(data.count);
                        $(".filter_data").empty().html(data.items_view);
                        swal("Success!", "Service has been removed!", 'success');
                    }
                });
            } else { }
        });
});

$(document).on('click', '.add-to-comparison', function(event){
    event.preventDefault();
    var product_id=$(this).attr("data-product-id");
    $.ajax({
        url:"/product/comparison/add-item",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:{id:product_id},
        success: function (data) {
            if(data.status == "exist_item_identified") {
                swal("Oops! This Product has already in your comparison list!", {
                    icon: "error",
                });
            }else{
                $(".comparison_item_count").html(data.comparison_count);
                swal("Success! Product has been added to your comparison list!",{
                    icon: "success",
                });
            }
        }
    });
});
