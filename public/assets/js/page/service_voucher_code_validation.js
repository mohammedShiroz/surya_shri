$(".apply_code").on('click',function(){
    if($('#voucher_code').val()) {
        var isChecked = $("#by_partner").is(":checked");
        var is_partner = null;
        if(isChecked){ is_partner = 'yes'}
        //:Check valid code
        $.ajax({
            url: "/clinique/reservations/voucher/valid",
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                code: $('#voucher_code').val(),
                total: $('#cart_sub_total').val(),
                service_id: $('#service_id').val(),
                is_partner: is_partner,
            },
            success: function (data) {
                if (data['success']) {
                    $("#voucher_slot").slideDown();
                    $(".voucher_id").val(data.success.voucher.id);
                    $(".voucher_provide_by").val(data.success.voucher_owner_id);
                    $(".voucher_name").html('');
                    $(".voucher_name").append(data.success.voucher.name);
                    var voucher_type = ''; var voucher_owner = '';
                    if (data.success.voucher.voucher_type === "Reservation") { voucher_type = "Reservation";
                    } else { voucher_type = "Invalid"; }

                    if(data.success.voucher_owner_name != 'admin'){
                        voucher_owner = ' provide by '+data.success.voucher_owner_name;
                    }

                    $(".voucher_name").append('<small style="font-size: 13px; display: block;">(' + voucher_type + ' '+voucher_owner +')</small>');
                    $(".voucher_description").html(data.success.voucher.description);
                    reset();
                    if (data.success.voucher.voucher_type == "Reservation") {
                        if (data.success.voucher.discount_type == "price") {
                            var discount_price = (parseFloat($("#cart_sub_total").val()) - parseFloat(data.success.voucher.discount));
                            $(".update_discount_amount").html("LKR. " + data.success.voucher.discount + ".00");
                            $("#discount_show_slot").fadeIn();
                            var cart_sub_total = (parseFloat($("#cart_sub_total").val()) - data.success.voucher.discount);
                            if (data.success.voucher.discount > parseFloat($("#cart_sub_total").val())) {
                                cart_sub_total = 0;
                                $("#points_show_slot").fadeIn();
                                var balance_amount = (data.success.voucher.discount - parseFloat($("#cart_sub_total").val()));
                                $(".update_earned_points").html((balance_amount / $("#per_points_amount").val()) + ' Points');
                            } else {
                                $("#points_show_slot").fadeOut(); $(".update_earned_points").html('');
                            }
                            $(".update_cart_total_amount").html('LKR. ' + cart_sub_total + '.00 &nbsp; <del>LKR. ' + $("#cart_sub_total").val() + '.00</del>');
                            $(".updated_total_amount").html("LKR. " + cart_sub_total + ".00");
                            $(".updated_total_amount").val(cart_sub_total);

                        } else {
                            var discount_price = (((data.success.voucher.discount / 100) * parseFloat($("#cart_sub_total").val())));
                            $(".update_discount_amount").html("Rs. " + discount_price + ".00");
                            $("#discount_show_slot").fadeIn();
                            $(".update_cart_total_amount").html('Rs. ' + (parseFloat($("#cart_sub_total").val()) - discount_price) + '.00 &nbsp; <del>Rs. ' + $("#cart_sub_total").val() + '.00</del> <span class="text-success">(' + data.success.voucher.discount + '%off)</span>');
                            var total = (parseFloat($("#cart_sub_total").val()) - discount_price);
                            $(".updated_total_amount").html("Rs. " + total + ".00");
                            $(".updated_total_amount").val(total);
                            $("#points_show_slot").fadeOut(); $(".update_earned_points").html('');
                        }
                    } else {

                    }
                    swal(data.success.title, data.success.text, "success");
                    $("#voucher_code").attr('disabled',true);
                    $(".apply_code").attr('disabled',true);
                }

                if (data['success_coupon_code']) {
                    $("#voucher_slot").slideDown();
                    $(".voucher_id").val(null);
                    $(".coupon_id").val(data.success_coupon_code.coupon_id);
                    $(".users_code").val(data.success_coupon_code.user_code);
                    $(".users_code_id").val(data.success_coupon_code.user_code_id);
                    $(".voucher_ref_by").val(data.success_coupon_code.voucher_owner_id);
                    $(".voucher_name").html('');
                    $(".voucher_name").append(data.success_coupon_code.voucher_name);
                    var voucher_owner = 'Provide by '+data.success_coupon_code.voucher_owner_name;

                    $(".voucher_name").append('<small style="font-size: 13px; display: block;">(' +voucher_owner +')</small>');
                    $(".voucher_description").html('As a Partner, you are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.');
                    reset();

                    $("#fetch_booking_items").empty();
                    $("#fetch_booking_items").append(data.success_coupon_code.booking_items);
                    $("#fetch_amount").empty();
                    $("#fetch_amount").append(data.success_coupon_code.booking_amount);

                    $("#fetch_online_pay").empty();
                    $("#fetch_online_pay").append(data.success_coupon_code.booking_online_amount);
                    swal(data.success_coupon_code.title, data.success_coupon_code.text, "success");
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
                        swal(data.error.title, data.error.text, "success");
                        $("#voucher_code").attr('disabled',true);
                        $(".apply_code").attr('disabled',true);

                    }else{
                        swal(data.error.title, data.error.text, "error");
                        $("#voucher_code").attr('disabled',false);
                        $(".apply_code").attr('disabled',false);
                    }
                }
            }
        });
    }else{
        swal('Required Voucher Code', 'Please type valid voucher code.', "error");
    }
});

$(".remove_code").on('click',function(){
    swal({
        title: 'Remove Voucher',
        text: "Are you sure want to remove?",
        icon: "warning",
        buttons: [
            'No, cancel it!',
            'Yes Remove.'
        ],
        dangerMode: true,
    }).then(function(isConfirm) {
        if (isConfirm) {
            $("#voucher_slot").slideUp();
            $(".voucher_id").val(null);
            $(".voucher_provide_by").val(null);
            $("#voucher_code").val(null);
            $(".voucher_ref_by").val(null);
            $(".coupon_id").val(null);
            $(".users_code").val(null);
            $(".users_code_id").val(null);
            $.ajax({
                url:"/clinique/reservations/voucher/remove/voucher",
                method:"POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    service_id: $('#service_id').val(),
                },
                success:function(data){
                    $("#fetch_booking_items").empty(); $("#fetch_booking_items").append(data.booking_items);
                    $("#fetch_amount").empty(); $("#fetch_amount").append(data.booking_amount);
                    $("#fetch_online_pay").empty(); $("#fetch_online_pay").append(data.booking_online_amount);
                }
            });

            reset();
            swal('Success', 'Voucher Code has been removed and restored previous shopping payment details.', "info");
        } else {
            swal('Notice', 'Cancelled', "info");
        }
    })

});
function reset() {
    $(".update_cart_total_amount").html('Rs. '+(parseFloat($("#cart_sub_total").val())+'.00'));
    $(".updated_total_amount").html('Rs. '+(parseFloat($("#default_total_amount").val()))+'.00');
    $(".updated_total_amount").val(parseFloat($("#default_total_amount").val()));
    $("#points_show_slot").fadeOut();
    $(".update_earned_points").html('');
    $(".update_discount_amount").html('');
    $("#discount_show_slot").fadeOut();
}
