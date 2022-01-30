$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) { return false; }
    });
    $('#first_name').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z\\s]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('#last_name').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z\\s]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('.user_note_text').keypress(function(e) {
        var tval = $(".user_note_text").val(),
            tlength = tval.length,
            set = 1000,
            remain = parseInt(set - tlength);
        if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
            $(".user_note_error").slideDown('slow');
            $(".user_note_error").html('limit the character count to 1000');
            return false;
        }else{
            $(".user_note_error").slideUp('slow');
        }
    })

});
$(".next-step").click(function (e) {

    if($('.wizard .nav-tabs li.active').attr('id') == "select_step2"){
        var errors=false;
        errors = user_info_validation();
        if(errors == false){
            var active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            nextTab(active);
        }
    }else if($('.wizard .nav-tabs li.active').attr('id') == "select_step4"){
        if (!$("#get_payment_method").val()){
            $("#error_txt").html('Please select payment method to continue');
            $("#error_txt").fadeIn();
            setTimeout(function() {
                $("#error_txt").fadeOut()
            }, 5000);
        }else{

            if ($("#get_payment_method").val() == "online_payment") {
                var answer_one = null;
                var answer_two = null;
                var answer_three = null;
                if($("#a_answer_one").val()){ answer_one = $("#a_answer_one").val(); }
                if($("#a_answer_two").val()){ answer_two = $("#a_answer_two").val(); }
                if($("#a_answer_three").val()){ answer_three = $("#a_answer_three").val(); }
                var return_url = $(".host_url").val() + "/service/ps?order_id="+$("#order_code").val()+"&service_id=" + $("#service_id").val() + "&user_id=" + $("#user_id").val() + "&book_date=" + $("#book_date").val() + "&book_time=" + $("#book_time").val() + "&price=" + $("#price").val() + "&payment_method=" + $("#get_payment_method").val() + "&paid_amount=" + $(".updated_total_amount").val() + "&voucher_id=" + $(".voucher_id").val() + "&coupon_id=" + $(".coupon_id").val()  + "&voucher_provide_by=" + $(".voucher_provide_by").val() + "&voucher_ref_by=" + $(".voucher_ref_by").val() + "&customer_name=" + $("#first_name").val()+ "&customer_last_name=" + $("#last_name").val() + "&customer_email=" + $("#user_email").val() + "&customer_contact=" + $("#user_contact").val() + "&customer_nic=" + $("#user_nic").val() + "&customer_answer_one=" + answer_one + "&customer_answer_two=" + answer_two + "&customer_answer_three=" + answer_three + "&customer_note=" + $("#user_note").val()+ "&type=" + $("#booking_type").children("option:selected").val()+ "&uc=" + $(".users_code_id").val();
                $('.set_param_url').val(return_url);
                $("#submit_btn").prop('disabled', true);
                $("#submit_btn").html('<i class="fa fa-spin fa-spinner"></i> Progressing');
                setTimeout(function () {
                    document.getElementById('service_payment_form').submit();
                }, 3000);
            } else if ($("#get_payment_method").val() == "points_payment") {

                if($("#available_points").val() >=(parseFloat($(".updated_total_amount").val())/$("#per_points_amount").val())){
                    $("#submit_btn").prop('disabled', true);
                    $("#submit_btn").html('<i class="fa fa-spin fa-spinner"></i> Progressing');
                    setTimeout(function () {
                        document.getElementById('booking_service_form').submit();
                    }, 3000);
                } else {
                    Swal.fire({
                        type: 'info',
                        icon: 'info',
                        title: "<span class='text-uppercase'>"+$(".set-pay-points").val()+" Points Required</span>",
                        text: 'Unable to pay due to not enough available points. Please choose another payment mode and pay and make your reservation.',
                        showConfirmButton: true,
                        timer: 5000
                    });
                }
            }
        }
    }else{
        var errors=false;
        $("#error_txt").html('');
        $("#error_txt").fadeOut();
        if (!$(".booked_date").val()) {
            $("#error_txt").html('Please select date & time to continue');
            $("#error_txt").fadeIn();
            setTimeout(function() {
                $("#error_txt").fadeOut()
            }, 5000);
            errors = true;
        } else if (!$(".booked_time").val()) {
            $("#error_txt").html('Please, select a time to continue');
            $("#error_txt").fadeIn();
            setTimeout(function() {
                $("#error_txt").fadeOut()
            }, 5000);
            errors = true;
        }
        if (errors != true) {
            var active = $('.wizard .nav-tabs li.active');
            active.next().removeClass('disabled');
            nextTab(active);
            $('html, body').animate({
                scrollTop: ($("#booking_service_form").offset().top - 200)
            }, 1000);
        }
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
    $("#submit_btn").html('Continue <i class="icon-arrow-right"></i>');
    $("#get_payment_method").val(null);
    $("#intro-pay-tab").trigger('click');
    $("#online-pay-tab").removeClass("btn-fill-line btn-line-fill btn-dark text-white");
    $("#online-pay-tab").addClass("btn-line-fill");
    $("#points_payment-tab").removeClass("btn-dark text-white");
    $("#points_payment-tab").addClass("btn-line-fill");
}
$('.nav-tabs').on('click', 'li', function () {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
    $("#submit_btn").html('Continue <i class="icon-arrow-right"></i>');
    $("#get_payment_method").val(null);
    $("#intro-pay-tab").trigger('click');
    $("#online-pay-tab").removeClass("btn-fill-line btn-line-fill btn-dark text-white");
    $("#online-pay-tab").addClass("btn-line-fill");
    $("#points_payment-tab").removeClass("btn-dark text-white");
    $("#points_payment-tab").addClass("btn-line-fill");
});

$(".check_validation_by_number").click(function(){
    var errors=false;
    $("#error_txt").html(''); $("#error_txt").fadeOut();
    if(!$(".booked_date").val()){
        $("#error_txt").html('Please, Choose a date and time to continue'); $("#error_txt").fadeIn()
        errors=true;
    }else if(!$(".booked_time").val()){
        $("#error_txt").html('Please, Choose a time to continue'); $("#error_txt").fadeIn();
        errors=true;
    }
    if(errors == true){
        return false;
    }
});

function user_info_validation(){
    var errors=false;
    if($("#booking_type option:selected").val() == 'null'){
        $(".booking_type_error").html('<i class="fa fa-info-circle"></i> Please choose your reservation type.');
        $(".booking_type_error").slideDown('slow');
        $("#booking_type").focus();
        errors=true;
    }

    if (!$("#first_name").val()) {
        $(".first_name_error").html('<i class="fa fa-info-circle"></i> Please text patient first name.');
        $(".first_name_error").slideDown('slow');
        $("#first_name").focus();
        errors=true;
    }
    if (!$("#last_name").val()) {
        $(".last_name_error").html('<i class="fa fa-info-circle"></i> Please text patient last name.');
        $(".last_name_error").slideDown('slow');
        $("#last_name").focus();
        errors=true;
    }
    if (!$("#user_contact").val()) {
        $(".user_contact_error").html('<i class="fa fa-info-circle"></i> Please text your phone number.');
        $(".user_contact_error").slideDown('slow');
        $("#user_contact").focus();
        errors=true;
    }
    // if (!$("#user_nic").val()) {
    //     $(".user_nic_error").html('<i class="fa fa-info-circle"></i> Please text your NIC/Passport Number.');
    //     $(".user_nic_error").slideDown('slow');
    //     $("#user_nic").focus();
    //     errors=true;
    // }

    if($("#form_type").val() == "Specific Form"){
        if($("#a_question_one").val() && !$("#a_answer_one").val()){

            $(".a_answer_one_error").html('<i class="fa fa-info-circle"></i> Please text your answer.');
            $(".a_answer_one_error").slideDown('slow');
            $("#a_answer_one").focus();
            errors=true;
        }

        if($("#a_question_two").val() && !$("#a_answer_two").val()){

            $(".a_answer_two_error").html('<i class="fa fa-info-circle"></i> Please text your answer.');
            $(".a_answer_two_error").slideDown('slow');
            $("#a_answer_two").focus();
            errors=true;
        }

        if($("#a_question_three").val() && !$("#a_answer_three").val()){

            $(".a_answer_three_error").html('<i class="fa fa-info-circle"></i> Please text your answer.');
            $(".a_answer_three_error").slideDown('slow');
            $("#a_answer_three").focus();
            errors=true;
        }
    }

    return errors;
}

$("#booking_type").change(function(){
    if($("#booking_type option:selected").val() == 'For myself'){

        $("#first_name").attr('readonly', 'true');
        $("#last_name").attr('readonly', 'true');
        $("#user_nic").attr('readonly', 'true');
        $("#user_email").attr('readonly', 'true');

    }else if($("#booking_type option:selected").val() === "For someone else"){

        $("#first_name").removeAttr('readonly');
        $("#last_name").removeAttr('readonly');
        $("#user_email").removeAttr('readonly');
        $("#user_nic").attr('readonly', 'true');
    }
});

$(".input_identity").change(function(){

    if ($("#first_name").val() != '') {
        $(".first_name_error").slideUp('slow');
    }
    if ($("#last_name").val() != '') {
        $(".last_name_error").slideUp('slow');
    }
    if ($("#user_contact").val() != '') {
        $(".user_contact_error").slideUp('slow');
    }
    if ($("#user_nic").val() != '') {
        $(".user_nic_error").slideUp('slow');
    }
    if ($("#booking_type option:selected").val() != 'null') {
        $(".booking_type_error").slideUp('slow');
    }

    if($("#form_type").val() == "Specific Form"){

        if($("#a_question_one").val() && $("#a_answer_one").val()){
            $(".a_answer_one_error").slideUp('slow');
        }

        if($("#a_question_two").val() && $("#a_answer_two").val()){
            $(".a_answer_two_error").slideUp('slow');
        }

        if($("#a_question_three").val() && $("#a_answer_three").val()){
            $(".a_answer_three_error").slideUp('slow');
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
        $("#submit_btn").html('Proceed to Payment');

    } else if (data == "points_payment") {
        set_payment_points();
        $("#get_payment_method").val('points_payment');
        $("#online-pay-tab").addClass("btn-line-fill");
        $("#online-pay-tab").removeClass("btn-dark text-white");

        $("#points_payment-tab").removeClass("btn-line-fill");
        $("#points_payment-tab").addClass("btn-dark text-white");
        $("#submit_btn").html('Proceed to Payment');
    } else {
        $("#get_payment_method").val(null);
    }
}
