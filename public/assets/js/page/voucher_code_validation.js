$(".apply_code").on('click',function(){
    if($('#voucher_code').val()) {
        var isChecked = $("#by_partner").is(":checked");
        var is_partner = null;
        if(isChecked){ is_partner = 'yes'}
        //:Check valid code
        $.ajax({
            url: "/checkout/voucher/valid",
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                code: $('#voucher_code').val(),
                total: $('#cart_sub_total').val(),
                is_partner: is_partner,
            },
            success: function (data) {
                if (data['success']) {
                    if (data.success.voucher.voucher_type === "Shipping Amount" && $("#shipping_delivery_method option:selected").val() == 'Store Pickup'){ }
                    else{
                        $("#voucher_slot").slideDown();
                        $(".voucher_id").val(data.success.voucher.id);
                        $(".voucher_provide_by").val(data.success.voucher_owner_id);
                        $(".voucher_name").html('');
                        $(".voucher_name").append(data.success.voucher.name);
                        var voucher_type = ''; var voucher_owner = '';
                        if (data.success.voucher.voucher_type === "Purchase") { voucher_type = "Purchase Voucher";
                        }else if (data.success.voucher.voucher_type === "Shipping Amount") { voucher_type = "Shipping Voucher"; }

                        if(data.success.voucher_owner_name != 'admin'){
                            voucher_owner = ' provide by '+data.success.voucher_owner_name;
                        }
                        $(".voucher_name").append('<small style="font-size: 13px; display: block;">(' + voucher_type + ' '+voucher_owner +')</small>');
                        $(".voucher_description").html(data.success.voucher.description);
                        reset();
                    }

                    if (data.success.voucher.voucher_type == "Purchase") {
                        if (data.success.voucher.discount_type == "price") {
                            var discount_price = ((parseFloat($("#cart_sub_total").val()) + parseFloat($("#default_shipping_amount").val())) - parseFloat(data.success.voucher.discount));
                            $(".update_discount_amount").html("LKR. " + data.success.voucher.discount + ".00");
                            $("#discount_show_slot").fadeIn();
                            var cart_sub_total = (parseFloat($("#cart_sub_total").val()) - data.success.voucher.discount);
                            if (data.success.voucher.discount > parseFloat($("#cart_sub_total").val())) {
                                cart_sub_total = 0;
                                $("#points_show_slot").fadeIn();
                                var balance_amount = (data.success.voucher.discount - parseFloat($("#cart_sub_total").val()));
                                $(".update_earned_points").html((balance_amount / $("#per_points_amount").val()) + ' Points');
                            } else {
                                $("#points_show_slot").fadeOut();
                                $(".update_earned_points").html('');
                            }

                            $(".update_cart_total_amount").html('LKR. ' + cart_sub_total + '.00 &nbsp; <del>LKR. ' + $("#cart_sub_total").val() + '.00</del>');
                            //:check delivery method
                            if($("#shipping_delivery_method option:selected").val() == 'Store Pickup'){
                                $(".updated_total_amount").html("LKR. " + cart_sub_total + ".00");
                                $(".updated_total_amount").val(cart_sub_total);

                            }else if($("#shipping_delivery_method option:selected").val() == 'Delivery'){
                                $(".update_cart_total_amount").html('LKR. ' + cart_sub_total + '.00 &nbsp; <del>LKR. ' + $("#cart_sub_total").val() + '.00</del>');
                                $(".updated_total_amount").html("LKR. " + (cart_sub_total + parseFloat($("#default_shipping_amount").val())) + ".00");
                                $(".updated_total_amount").val(cart_sub_total + parseFloat($("#default_shipping_amount").val()));
                            }

                        }else if(data.success.voucher.discount_type == "percentage") {
                            var discount_price = (((data.success.voucher.discount / 100) * parseFloat($("#cart_sub_total").val())));
                            $(".update_discount_amount").html("LKR. " + discount_price + ".00");
                            $("#discount_show_slot").fadeIn();
                            $(".update_cart_total_amount").html('LKR. ' + (parseFloat($("#cart_sub_total").val()) - discount_price) + '.00 &nbsp; <del>LKR. ' + $("#cart_sub_total").val() + '.00</del> <span class="text-success">(' + data.success.voucher.discount + '%off)</span>');

                            var total = 0;
                            if($("#shipping_delivery_method option:selected").val() == 'Store Pickup'){
                                total = (parseFloat($("#cart_sub_total").val()) - discount_price);
                            }else if($("#shipping_delivery_method option:selected").val() == 'Delivery'){
                                total = (parseFloat($("#cart_sub_total").val()) - discount_price) + parseFloat($("#default_shipping_amount").val());
                            }

                            $(".updated_total_amount").html("LKR. " + total + ".00");
                            $(".updated_total_amount").val(total);
                            $("#points_show_slot").fadeOut();
                            $(".update_earned_points").html('');
                        }
                    }else if (data.success.voucher.voucher_type === "Shipping Amount"){
                        //:check delivery method
                        if($("#shipping_delivery_method option:selected").val() == 'Store Pickup'){

                            Swal.fire({
                                type: 'error',
                                icon: 'error',
                                title: "<span class='text-uppercase'>Notice</span>",
                                text: "Your delivery method is Store Pickup. Therefor you cannot apply this voucher.",
                                showConfirmButton: true,
                                timer: 5000
                            });

                        }else if($("#shipping_delivery_method option:selected").val() == 'Delivery'){

                            if (data.success.voucher.discount_type == "price") {
                                $(".update_discount_amount").html("LKR. " + data.success.voucher.discount + ".00");
                                $("#discount_show_slot").fadeIn();
                                var discount_shipping_amount = (parseFloat($("#default_shipping_amount").val()) - data.success.voucher.discount);
                                if (data.success.voucher.discount > parseFloat($("#default_shipping_amount").val())) {
                                    discount_shipping_amount = 0;
                                    $("#points_show_slot").fadeIn();
                                    var balance_amount = (data.success.voucher.discount - parseFloat($("#default_shipping_amount").val()));
                                    $(".update_earned_points").html((balance_amount / $("#per_points_amount").val()) + ' Points');
                                } else {
                                    $("#points_show_slot").fadeOut();
                                    $(".update_earned_points").html('');
                                }
                                $(".updated_shipping_amount").html('LKR. ' + discount_shipping_amount + '.00 &nbsp; <del>LKR. ' + $("#default_shipping_amount").val() + '.00</del>');
                                $(".updated_shipping_amount").val(discount_shipping_amount);
                                $(".updated_total_amount").html("LKR. " + (discount_shipping_amount + parseFloat($("#cart_sub_total").val())) + ".00");
                                $(".updated_total_amount").val(discount_shipping_amount + parseFloat($("#cart_sub_total").val()));

                            } else {
                                var discount_price = (((data.success.voucher.discount / 100) * parseFloat($("#default_shipping_amount").val())));
                                $(".update_discount_amount").html("LKR. " + discount_price + ".00");
                                $("#discount_show_slot").fadeIn();
                                $(".updated_shipping_amount").html('LKR. ' + (parseFloat($("#default_shipping_amount").val()) - discount_price) + '.00 &nbsp; <del>LKR. ' + $("#default_shipping_amount").val() + '.00</del> <span class="text-success">(' + data.success.voucher.discount + '%off)</span>');
                                $(".updated_shipping_amount").val((parseFloat($("#default_shipping_amount").val()) - discount_price));
                                var total = ((parseFloat($("#default_shipping_amount").val()) - discount_price) + parseFloat($("#cart_sub_total").val()));
                                $(".updated_total_amount").html("LKR. " + total + ".00");
                                $(".updated_total_amount").val(total);
                                $("#points_show_slot").fadeOut();
                                $(".update_earned_points").html('');
                            }
                        }

                    }

                    if (data.success.voucher.voucher_type === "Shipping Amount" && $("#shipping_delivery_method option:selected").val() === 'Store Pickup') { }
                    else{
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: "<span class='text-uppercase'>" + data.success.title + "</span>",
                            text: data.success.text,
                            showConfirmButton: false,
                            timer: 3500
                        });
                        $("#voucher_code").attr('disabled',true);
                        $(".apply_code").attr('disabled',true);
                    }
                }

                if (data['success_coupon_code']) {
                    $("#voucher_slot").slideDown();
                    $(".voucher_id").val(null);
                    $(".coupon_id").val(data.success_coupon_code.coupon_id);
                    $(".user_code").val(data.success_coupon_code.user_code);
                    $(".voucher_ref_by").val(data.success_coupon_code.voucher_owner_id);
                    $(".voucher_name").html('');
                    $(".voucher_name").append(data.success_coupon_code.voucher_name);
                    var voucher_owner = 'Provide by '+data.success_coupon_code.voucher_owner_name;

                    $(".voucher_name").append('<small style="font-size: 13px; display: block;">(' +voucher_owner +')</small>');
                    $(".voucher_description").html('As a Partner, you are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.');
                    reset();
                    $("#fetch_order_items").empty();
                    $("#fetch_order_items").append(data.success_coupon_code.order_items);
                    $("#fetch_total_amount").empty();
                    $("#fetch_total_amount").append(data.success_coupon_code.order_amount);

                    $("#fetch_online_pay").empty();
                    $("#fetch_online_pay").append(data.success_coupon_code.order_online_amount);

                    if($("#shipping_delivery_method option:selected").val() == 'Store Pickup'){
                        $("#show-pre-address").hide();
                        $("#show-contact-details").show();
                        $(".updated_shipping_amount").val(0);
                        $(".updated_shipping_amount").html("LKR. 0.00");
                        $(".updated_total_amount").html("LKR. " +parseFloat($("#cart_sub_total").val()) + ".00");
                        $(".updated_total_amount").val(parseFloat($("#cart_sub_total").val()));

                    }else if($("#shipping_delivery_method option:selected").val() == 'Delivery'){
                        $("#show-pre-address").show();
                        $("#show-contact-details").hide();
                        $(".updated_shipping_amount").val(parseFloat($("#default_shipping_amount").val()));
                        $(".updated_shipping_amount").html("LKR. " +parseFloat($("#default_shipping_amount").val()) + ".00");

                        $(".updated_total_amount").html("LKR. " + (parseFloat($("#default_shipping_amount").val()) + parseFloat($("#cart_sub_total").val())) + ".00");
                        $(".updated_total_amount").val(parseFloat($("#default_shipping_amount").val()) + parseFloat($("#cart_sub_total").val()));
                    }
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: "<span class='text-uppercase'>" + data.success_coupon_code.title + "</span>",
                        text: data.success_coupon_code.text,
                        showConfirmButton: false,
                        timer: 3500
                    });
                    $("#voucher_code").attr('disabled',true);
                    $(".apply_code").attr('disabled',true);
                }

                if (data['error']) {
                    if(data.error.title == "Code Activated"){
                        $("#voucher_slot").slideDown();
                        $(".voucher_id").val(null);
                        $(".coupon_id").val(null);
                        $(".users_code").val(null);
                        $(".users_code_id").val(null);
                        $(".voucher_ref_by").val(null);
                        $(".voucher_name").html('');
                        $(".voucher_name").append('Coupon Code Activated');
                        $(".voucher_name").append('');
                        $(".voucher_description").html('As a Partner, you are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.');
                        reset();
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: "<span class='text-uppercase'>" + data.error.title + "</span>",
                            text: data.error.text,
                            showConfirmButton: true,
                            timer: 5000
                        });
                        $("#voucher_code").attr('disabled',true);
                        $(".apply_code").attr('disabled',true);

                    }else{
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: "<span class='text-uppercase'>" + data.error.title + "</span>",
                            text: data.error.text,
                            showConfirmButton: true,
                            timer: 5000
                        });
                        $("#voucher_code").attr('disabled',false);
                        $(".apply_code").attr('disabled',false);
                    }




                }
            }
        });
    }else{
        Swal.fire({
            type: 'error',
            icon: 'error',
            title: "<span class='text-uppercase'>Required Voucher Code</span>",
            text: 'Please type valid voucher code.',
            showConfirmButton: true,
            timer: 3000
        });
    }
});

$(".remove_code").on('click',function(){
    swal.fire({
        title: 'Remove Voucher',
        text: "Are you sure want to remove?",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $("#voucher_slot").slideUp();
            $(".voucher_id").val(null);
            $(".voucher_provide_by").val(null);
            $(".voucher_ref_by").val(null);
            $("#voucher_code").val(null);
            $(".coupon_id").val(null);
            $(".user_code").val(null);

            $.ajax({
                url:"/checkout/voucher/remove/voucher",
                method:"POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    $("#fetch_order_items").empty(); $("#fetch_order_items").append(data.order_items);
                    $("#fetch_total_amount").empty(); $("#fetch_total_amount").append(data.order_amount);
                    $("#fetch_online_pay").empty(); $("#fetch_online_pay").append(data.order_online_amount);
                }
            });

            reset();
            swal.fire(
                {
                    type: 'info',
                    icon: 'info',
                    title: 'Success',
                    text: 'Voucher Code has been removed and restored previous shopping payment details.',
                    showConfirmButton: false,
                    timer: 3500
                }
            );
        } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swal.fire(
                {
                    type: 'info',
                    icon: 'info',
                    title: 'Cancelled',
                    showConfirmButton: false,
                    timer: 1000
                }
            )
        }
    });
});
function reset() {

    $("#points_show_slot").fadeOut();
    $(".update_earned_points").html('');
    $(".update_cart_total_amount").html('LKR. '+(parseFloat($("#cart_sub_total").val())+'.00'));

    if($("#shipping_delivery_method option:selected").val() == 'Store Pickup'){
        $(".updated_shipping_amount").html('LKR. 0.00');
        $(".updated_shipping_amount").val(0);
        $(".updated_total_amount").html("LKR. " +parseFloat($("#cart_sub_total").val()) + ".00");
        $(".updated_total_amount").val(parseFloat($("#cart_sub_total").val()));

    }else if($("#shipping_delivery_method option:selected").val() == 'Delivery'){
        $(".updated_shipping_amount").html('LKR. '+(parseFloat($("#default_shipping_amount").val())+'.00'));
        $(".updated_shipping_amount").val((parseFloat($("#default_shipping_amount").val())));
        $(".updated_total_amount").html('LKR. '+(parseFloat($("#default_total_amount").val()))+'.00');
        $(".updated_total_amount").val(parseFloat($("#default_total_amount").val()));
    }
    $(".update_discount_amount").html('');
    $("#discount_show_slot").fadeOut();
}
