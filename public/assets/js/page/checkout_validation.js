$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) { return false; }
    });
});

function validateEmail(emailaddress) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(emailaddress);
}

$(".next-step").click(function (e) {
    var type=$(this).attr('data-type');
    if(type == "shipping_info"){
        var errors=false;
        errors=shipping_address_validation();
        if(errors != true){
            var active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            nextTab(active);
        }
    }else if(type == "review_cart"){
        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);
    }else if(type == "pay-and-order"){
        var errors=false;
        var pay_method=$("#get_payment_method").val();
        if(pay_method){

            if(pay_method == "online_payment"){
                var return_url = $(".host_url").val() + "/checkout/payment-success?order_id="+ $("#order_code").val() +"&user_id=" + $("#user_id").val() + "&total=" + $(".updated_total_amount").val() + "&payment_method=" + $("#get_payment_method").val() + "&shipping_amount=" + $(".updated_shipping_amount").val() + "&voucher_id=" + $(".voucher_id").val() + "&user_code=" + $(".user_code").val()+ "&coupon_id=" + $(".coupon_id").val()+ "&voucher_provide_by=" + $(".voucher_provide_by").val() + "&voucher_ref_by=" + $(".voucher_ref_by").val() + "&paid_amount=" + $(".updated_total_amount").val() + "&customer_name=" + $("#shipping_name").val() + "&customer_address=" + $("#shipping_address").children("option:selected").val() + "&customer_country=" + $("#shipping_country").children("option:selected").val() + "&customer_city=" + $("#shipping_city").children("option:selected").val() + "&customer_email=" + $("#shipping_email").val() + "&customer_contact=" + $("#shipping_phone").val() + "&customer_note=" + $("#customer_note").val()+ "&delivery_method=" + $("#shipping_delivery_method").children("option:selected").val()+ "&pre_address=" + $("#pre_address").val();
                $('.set_param_url').val(return_url);
                $("#pay-and-order").prop('disabled', true);
                $("#pay-and-order").html('<i class="fa fa-spin fa-spinner"></i> Progressing');
                setTimeout(function () {
                    document.getElementById('order_payment_form').submit();
                }, 3000);

            }else if(pay_method == "points_payment"){
                if($("#available_points").val() >=(parseFloat($(".updated_total_amount").val())/$("#per_points_amount").val())){
                    $("#pay-and-order").prop('disabled', true);
                    $("#pay-and-order").html('<i class="fa fa-spin fa-spinner"></i> Progressing');
                    setTimeout(function () {
                        document.getElementById('place-order-form').submit();
                    }, 3000);
                } else {
                    Swal.fire({
                        type: 'info',
                        icon: 'info',
                        title: "<span class='text-uppercase'>"+$(".set-pay-points").val()+" Points Required</span>",
                        text: 'Unable to pay due to not enough available points. Please choose another payment mode and pay and place your order.',
                        showConfirmButton: true,
                        timer: 5000
                    });
                }

            }else{}

        }else{
            Swal.fire({
                type: 'info',
                icon: 'info',
                title: "<span class='text-uppercase'>Required payment mode</span>",
                text: 'Please choose a payment mode and pay and place your order.',
                showConfirmButton: true,
                timer: 5000
            });
        }
    }
});

function shipping_address_validation(){
    var errors=false;
    if (!$("#shipping_name").val()) {
        $(".shipping_name_error").html('<i class="fa fa-info-circle"></i> Please text buyer name.');
        $(".shipping_name_error").slideDown('slow');
        $("#shipping_name").focus();
        errors=true;
    }
    if ($("#shipping_address option:selected").val() == 'null') {
        $(".shipping_address_error").html('<i class="fa fa-info-circle"></i> Please select shipping address.');
        $(".shipping_address_error").slideDown('slow');
        $("#shipping_address").focus();
        errors=true;
    }
    if($("#shipping_country option:selected").val() == 'null'){
        $(".shipping_country_error").html('<i class="fa fa-info-circle"></i> Please choose your country.');
        $(".shipping_country_error").slideDown('slow');
        $("#shipping_country").focus();
        errors=true;
    }
    if ($("#shipping_city option:selected").val() == 'null') {
        $(".shipping_city_error").html('<i class="fa fa-info-circle"></i> Please choose your city.');
        $(".shipping_city_error").slideDown('slow');
        $("#shipping_city").focus();
        errors=true;
    }
    if (!$("#shipping_phone").val()) {
        $(".shipping_phone_error").html('<i class="fa fa-info-circle"></i> Please text your phone number.');
        $(".shipping_phone_error").slideDown('slow');
        $("#shipping_phone").focus();
        errors=true;
    }
    if (!$("#shipping_email").val()) {
        $(".shipping_email_error").html('<i class="fa fa-info-circle"></i> Please text your phone number.');
        $(".shipping_email_error").slideDown('slow');
        $("#shipping_email").focus();
        errors=true;
    }
    if($("#shipping_delivery_method option:selected").val() == 'null'){
        $(".shipping_delivery_method_error").html('<i class="fa fa-info-circle"></i> Please choose your delivery method.');
        $(".shipping_delivery_method_error").slideDown('slow');
        $("#shipping_delivery_method").focus();
        errors=true;
    }
    return errors;
}

$("#shipping_delivery_method").change(function(){
    $("#voucher_slot").slideUp();
    $(".voucher_id").val(null);
    $(".voucher_provide_by").val(null);
    $("#voucher_code").val(null);
    $(".voucher_ref_by").val(null);
    $(".coupon_id").val(null);
    $(".user_code").val(null);
    reset();

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

});

$(".input_identity").change(function(){

    if ($("#shipping_name").val() != '') {
        $(".shipping_name_error").slideUp('slow');
    }
    if ($("#shipping_address option:selected").val() != 'null') {
        $(".shipping_address_error").slideUp('slow');
    }
    if($("#shipping_country option:selected").val() != 'null'){
        $(".shipping_country_error").slideUp('slow');
    }
    if ($("#shipping_city option:selected").val() != 'null') {
        $(".shipping_city_error").slideUp('slow');
    }
    if ($("#shipping_phone").val() != '') {
        $(".shipping_phone_error").slideUp('slow');
    }
    if ($("#shipping_email").val() != '') {
        $(".shipping_email_error").slideUp('slow');
    }
    if ($("#shipping_delivery_method option:selected").val() != 'null') {
        $(".shipping_delivery_method_error").slideUp('slow');
    }
});


$(".prev-step").click(function (e) {
    var active = $('.wizard .nav-tabs li.active');
    prevTab(active);
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
    $("#get_payment_method").val(null);
    $("#intro-pay-tab").trigger('click');
    $("#online-pay-tab").removeClass("btn-fill-line btn-line-fill btn-dark text-white");
    $("#online-pay-tab").addClass("btn-line-fill");
    $("#points_payment-tab").removeClass("btn-dark text-white");
    $("#points_payment-tab").addClass("btn-line-fill");
}
$('.nav-tabs').on('click', 'li', function () {
    if($(this).children("a").attr('data-type') != 'block'){
        $('.nav-tabs li.active').removeClass('active');
        $(this).addClass('active');
        $("#get_payment_method").val(null);
        $("#intro-pay-tab").trigger('click');
        $("#online-pay-tab").removeClass("btn-fill-line btn-line-fill btn-dark text-white");
        $("#online-pay-tab").addClass("btn-line-fill");
        $("#points_payment-tab").removeClass("btn-dark text-white");
        $("#points_payment-tab").addClass("btn-line-fill");
    }
});

$(".check_validation_by_number").click(function(){
    var types=$(this).attr('data-type');
    if(types == "shipping_info"){
        if(shipping_address_validation() == true){
            return false;
        }
    }
});

function set_payment_points() {
    var pay_amount =parseFloat($(".updated_total_amount").val());
    $(".set-pay-points").html(pay_amount*$("#per_points_amount").val()+' Points');
    $(".set-pay-points").val(pay_amount*$("#per_points_amount").val());

    if(parseFloat($("#available_points").val()) > parseFloat($(".set-pay-points").val())){
        $(".enough-points-msg").fadeIn();
        $(".not-enough-points-msg").fadeOut();
    }else{
        $(".enough-points-msg").fadeOut();
        $(".not-enough-points-msg").fadeIn();
    }
}

function set_pay_method(data) {
    if (data == "online_payment") {
        $("#get_payment_method").val('online_payment');
        $("#online-pay-tab").addClass("btn-dark text-white");
        $("#online-pay-tab").removeClass("btn-fill-line btn-line-fill");
        $("#points_payment-tab").removeClass("btn-dark text-white");
        $("#points_payment-tab").addClass("btn-line-fill");

    } else if (data == "points_payment") {
        set_payment_points();
        $("#get_payment_method").val('points_payment');
        $("#online-pay-tab").addClass("btn-line-fill");
        $("#online-pay-tab").removeClass("btn-dark text-white");
        $("#points_payment-tab").removeClass("btn-line-fill");
        $("#points_payment-tab").addClass("btn-dark text-white");
    } else {
        $("#get_payment_method").val(null);
    }
}
