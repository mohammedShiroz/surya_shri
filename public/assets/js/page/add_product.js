$(document).ready(function () {
    $('.search-select').select2();
    $('#m_cat').on('change', function () {
        var category_id = this.value;
        $.ajax({
            url: "/fetch-subcategory",
            type: "GET",
            data: { category_id: category_id, },
            cache: false,
            success: function (result) {
                $("#sub_cat").html(result);
                $("#category_select").fadeOut();
                $("#sub_category_select").fadeOut();
                $("#category_select").slideDown();
            }
        });
    });

    $('#sub_cat').on('change', function () {
        var category_id = this.value;
        $.ajax({
            url: "/fetch-last-category",
            type: "GET",
            data: {
                category_id: category_id,
            },
            cache: false,
            success: function (result) {
                $("#last_cat").html(result);
                $("#sub_category_select").slideDown();
            }
        });
    });

    $('#p_deliverable').click(function () {
        if ($(this).prop("checked") == true) {
            $("#pro_deliverable").val('1');
        }
        else if ($(this).prop("checked") == false) {
            $("#pro_deliverable").val('0');
        }
    });

    $(".stock-group").change(function(){
        var chk_adv_pr=$("#product_advance_pricing").val();
        if(chk_adv_pr == 0) {
            if ($("#pro_stock_chk").prop("checked") == true) {
                $("#p_stock_check").val('STOCK');
                $(".stock_on_filed").fadeIn('slow');

            } else if ($("#pro_on_order_chk").prop("checked") == true) {
                $("#p_stock_check").val('ON_ORDER');
                $(".stock_on_filed").fadeOut('slow');
                $("#stock_count").val('0');
            }
        }else if(chk_adv_pr == 1){

            var str = $("#p_sizes").val();
            var sizes = str.split(",");
            if (sizes[0] != "") {
                for (var i = 0; i < sizes.length; i++) {

                    if ($("#pro_stock_chk").prop("checked") == true) {
                        $("#p_stock_check").val('STOCK');
                        $(".stock_on_filed_" + sizes[i]).fadeIn('slow');

                    } else if ($("#pro_on_order_chk").prop("checked") == true) {
                        $("#p_stock_check").val('ON_ORDER');
                        $(".stock_on_filed_" + sizes[i]).fadeOut('slow');
                        $("#stock_count_" + sizes[i]).val('0');
                    }
                }
            }
        }
    });

    $('#p_deliverable').click(function () {
        if ($(this).prop("checked") == true) {
            $("#pro_deliverable").val('1');
        }
        else if ($(this).prop("checked") == false) {
            $("#pro_deliverable").val('0');
        }
    });

    $('#p_negotiable').click(function () {
        if ($(this).prop("checked") == true) {
            $("#pro_negotiable").val('1');
        }
        else if ($(this).prop("checked") == false) {
            $("#pro_negotiable").val('0');
        }
    });

    $('.size_selector').click(function () {
        var get_size = get_selections('product-size');
        if(get_size.length >0){
            $("#advance_show_box").fadeIn('slow');
        }else{
            $("#advance_show_box").fadeOut('slow');
            $('#p_advance_pricing').prop('checked', false);
            $("#size_prefer_view").slideUp();
            $(".default_prize_inputs").slideDown();
            $("#product_advance_pricing").val('0');
        }
        $("#p_sizes").val(get_size);
    });

    $('.color_selector').click(function () {
        var get_colors = get_selections('product-colors'); $("#p_colors").val(get_colors);
    });

    $("#p_gender_pre").click(function () {
        if ($(this).prop("checked") == true) {
            $("#item_gender_privilege").val('1');
            $("#gender_selections").slideDown('slow');
        }
        else if ($(this).prop("checked") == false) {
            $("#item_gender_privilege").val('0');
            $("#gender_selections").slideUp('slow');
        }
    });

    $("#p_advance_pricing").click(function () {
        var str = $("#p_sizes").val();
        var sizes = str.split(",");
        var all_size_count = $("#size_count").val();
        for (var ic = 1; ic < all_size_count; ic++) {
            $(".prefer_size_tag_" + [ic]).hide();
        }
        if ($(this).prop("checked") == true) {
            if (sizes[0] != "") {
                $(".default_prize_inputs").slideUp();
                $("#size_prefer_view").slideDown('slow');
                $("#product_advance_pricing").val('1');
                for (var i = 0; i < sizes.length; i++) {
                    $(".prefer_size_tag_" + sizes[i]).show();
                }
            }
        }
        else if ($(this).prop("checked") == false) {
            $("#size_prefer_view").slideUp();
            $(".default_prize_inputs").slideDown();
            $("#product_advance_pricing").val('0');
        }
    });

    $('.select_product_country').on('change', function () {
        var country_id = $('select.select_product_country').find(':selected').data('id');
        $.ajax({
            url: "/fetch-city",
            type: "GET",
            data: { country_id: country_id },
            cache: false,
            success: function (result) {
                $(".select_product_city").html(result);
                $("#product_country_select").removeClass('col-md-12');
                $("#product_country_select").addClass('col-md-6');
                $("#product_city_select").slideDown();
            }
        });
    });
});

function get_selections(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function () {
        filter.push($(this).val());
    });
    return filter;
}

var image1_error=false;
var image2_error=false;
var image3_error=false;
var image4_error=false;
var image5_error=false;

$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) { return false; }
    });

    $(".next-step").click(function (e) {
        var type=$(this).attr('data-type');
        if(type == "item_info"){
            var errors=false;
            if($("#item_city option:selected").val() == 'null'){
                $(".error_msg").eq(5).html('<i class="fa fa-info-circle"></i> Please choose the item\'s city.');
                $(".error_msg").eq(5).slideDown('slow');
                $("#item_city").focus();
                errors=true;
            }
            if($("#item_country option:selected").val() == 'null'){
                $(".error_msg").eq(4).html('<i class="fa fa-info-circle"></i> Please choose the item\'s country.');
                $(".error_msg").eq(4).slideDown('slow');
                $("#item_country").focus();
                errors=true;
            }
            if($("#pro_text").val() == ''){
                $(".error_msg").eq(3).html('<i class="fa fa-info-circle"></i> Please text your item name.');
                $(".error_msg").eq(3).slideDown('slow');
                $("#pro_text").focus();
                errors=true;
            }
            if($("#m_cat option:selected").val() == 'null'){
                $(".error_msg").eq(0).html('<i class="fa fa-info-circle"></i> Please choose the item type.');
                $(".error_msg").eq(0).slideDown('slow');
                $("#m_cat").focus();
                errors=true;
            }else if($("#sub_cat option:selected").val() == "null"){
                $(".error_msg").eq(1).html('<i class="fa fa-info-circle"></i> Please choose the item category.');
                $(".error_msg").eq(1).slideDown('slow');
                $("#sub_cat").focus();
                errors=true;
            }else if($("#last_cat option:selected").val() == "null"){
                $(".error_msg").eq(2).html('<i class="fa fa-info-circle"></i> Please choose the item sub category.');
                $(".error_msg").eq(2).slideDown('slow');
                $("#last_cat").focus();
                errors=true;
            }
            if(errors != true){
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);
            }
        }else if(type == "item_image"){

            var errors=false;
            if ($('#product_image1').get(0).files.length === 0) {
                $(".error_msg").eq(6).html('<i class="fa fa-info-circle"></i> Please upload item\'s image.');
                $(".error_msg").eq(6).slideDown('slow'); $("#product_image1").focus();
                errors=true;
            }else
            {
                if(image1_error == true){
                    Check_validation('product_image1');
                    $(".error_msg").eq(6).slideDown('slow');
                    $("#product_image1").focus(); errors=true;
                }
                if ($('#product_image2').get(0).files.length === 1) {
                    if(image2_error == true){ Check_validation('product_image2'); $(".error_msg").eq(7).slideDown('slow'); $("#product_image2").focus(); errors=true;}
                }
                if ($('#product_image3').get(0).files.length === 1) {

                    if (image3_error == true) { Check_validation('product_image3'); $(".error_msg").eq(8).slideDown('slow'); $("#product_image3").focus(); errors = true;}
                }
                if ($('#product_image4').get(0).files.length === 1) {
                    if (image4_error == true) { Check_validation('product_image4'); $(".error_msg").eq(9).slideDown('slow'); $("#product_image4").focus(); errors = true;}
                }
                if ($('#product_image5').get(0).files.length === 1) {

                    if (image5_error == true) { Check_validation('product_image5'); $(".error_msg").eq(10).slideDown('slow'); $("#product_image5").focus(); errors = true;}
                }
                if(errors == false){
                    var active = $('.wizard .nav-tabs li.active');
                    active.next().removeClass('disabled');
                    nextTab(active);
                }
            }
        }else if(type == "item_preference"){

            var errors=false;
            if($("#item_condition option:selected").val() == 'null'){
                $(".error_msg").eq(11).html('<small><i class="fa fa-info-circle"></i> Please choose the item\'s condition info.<small>');
                $(".error_msg").eq(11).slideDown('slow');
                $("#item_condition").focus();
                errors=true;
            }

            if($("#product_advance_pricing").val() == 1){

                var str = $("#p_sizes").val();
                var sizes = str.split(",");
                if (sizes[0] != "") {
                    for (var i = 0; i < sizes.length; i++) {
                        if($("#product_price_" + sizes[i]).val() == ''){
                            $(".product_price_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Item price required.</small>');
                            $(".product_price_error_msg_" + sizes[i]).slideDown('slow');
                            $("#product_price_" + sizes[i]).focus();
                            errors=true;
                        }
                        if($("#item_company_percentage_" + sizes[i]).val() == ''){
                            $(".item_company_percentage_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Company Percentage required.</small>');
                            $(".item_company_percentage_error_msg_" + sizes[i]).slideDown('slow');
                            $("#item_company_percentage_" + sizes[i]).focus();
                            errors=true;
                        }
                        if($("#item_stock_" + sizes[i]).val() == ''){
                            $(".item_stock_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Item stock required.</small>');
                            $(".item_stock_error_msg_" + sizes[i]).slideDown('slow');
                            $("#item_stock_" + sizes[i]).focus();
                            errors=true;
                        }
                        if($("#product_weight_type_" + sizes[i]+" option:selected").val() == 'null'){
                            $(".product_weight_type_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Please choose the item\'s weight.<small>');
                            $(".product_weight_type_error_msg_" + sizes[i]).slideDown('slow');
                            $("#product_weight_type_" + sizes[i]).focus();
                            errors=true;
                        }
                    }
                }
            }else{

                if($("#product_price").val() == ''){
                    $(".error_msg").eq(12).html('<small><i class="fa fa-info-circle"></i> Item price required.</small>');
                    $(".error_msg").eq(12).slideDown('slow');
                    $("#product_price").focus();
                    errors=true;
                }
                if($("#product_company_percentage").val() == ''){
                    $(".error_msg").eq(13).html('<small><i class="fa fa-info-circle"></i> Company Percentage required.</small>');
                    $(".error_msg").eq(13).slideDown('slow');
                    $("#product_company_percentage").focus();
                    errors=true;
                }
                if($("#stock_count").val() == ''){
                    $(".error_msg").eq(15).html('<small><i class="fa fa-info-circle"></i> Item stock required.</small>');
                    $(".error_msg").eq(15).slideDown('slow');
                    $("#stock_count").focus();
                    errors=true;
                }

            }

            if(errors == false){
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);
            }
        }
        else if(type == "item_description") {

            var errors=false;
            var body_text=CKEDITOR.instances['product_body'].getData();
            if(body_text.length <= 0){
                $(".error_msg").eq(18).html('<small><i class="fa fa-info-circle"></i> Item Information required.</small>');
                $(".error_msg").eq(18).slideDown('slow');
                $("#product_body").focus();
                errors=true;
            }
            if($("#item_info").val().length < 20){
                $(".error_msg").eq(17).html('<small><i class="fa fa-info-circle"></i> Description should be in 20 words of letters.</small>');
                $(".error_msg").eq(17).slideDown('slow');
                $("#item_info").focus();
                errors=true;
            }
            if($("#item_info").val() == ''){
                $(".error_msg").eq(17).html('<small><i class="fa fa-info-circle"></i> Item Description required.</small>');
                $(".error_msg").eq(17).slideDown('slow');
                $("#item_info").focus();
                errors=true;
            }
            if(errors == false){
                $("#add-product-form").submit();
            }
        }
    });
    $(".prev-step").click(function (e) {
        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);
    });
});

$(".input_identity").change(function(){
    var get_selected_id=$(".input_identity").index(this);
    $(".error_msg").eq(get_selected_id).slideUp('slow');
    $(".error_msg").eq(get_selected_id).html('');

    if($("#item_condition option:selected").val() != 'null'){
        $(".error_msg").eq(11).slideUp('slow');
        $(".error_msg").eq(11).html('');
    }
    if($("#product_price").val() != ''){
        $(".error_msg").eq(12).slideUp('slow');
        $(".error_msg").eq(12).html('');
    }
    if($("#product_company_percentage").val() != '') {
        $(".error_msg").eq(13).slideUp('slow');
        $(".error_msg").eq(13).html('');
    }

    if($("#product_selling_percentage").val() != '') {
        $(".error_msg").eq(14).slideUp('slow');
        $(".error_msg").eq(14).html('');
    }
    if($("#stock_count").val() != '') {
        $(".error_msg").eq(15).slideUp('slow');
        $(".error_msg").eq(15).html('');
    }
    if($("#item_weight option:selected").val() != 'null') {

        $(".error_msg").eq(16).slideUp('slow');
        $(".error_msg").eq(16).html('');
    }
    if($("#item_info").val() != '') {

        $(".error_msg").eq(17).slideUp('slow');
        $(".error_msg").eq(17).html('');
    }

    if($("#item_info").val().length > 20) {
        $(".error_msg").eq(17).slideUp('slow');
        $(".error_msg").eq(17).html('');
    }

    var body_text=CKEDITOR.instances['product_body'].getData();
    if(body_text.length > 0) {
        $(".error_msg").eq(18).slideUp('slow');
        $(".error_msg").eq(18).html('');
    }
});

$(".input_identity_2").change(function(){

    var str = $("#p_sizes").val();
    var sizes = str.split(",");
    if (sizes[0] != "") {
        for (var i = 0; i < sizes.length; i++) {
            if($("#item_company_percentage_" + sizes[i]).val() != ''){
                $(".item_company_percentage_error_msg_" + sizes[i]).slideDown('slow');
                $(".item_company_percentage_error_msg_" + sizes[i]).html('');
            }
            if($("#item_selling_percentage_" + sizes[i]).val() != ''){
                $(".item_selling_percentage__error_msg_" + sizes[i]).slideDown('slow');
                $(".item_selling_percentage__error_msg_" + sizes[i]).html('');
            }
            if($("#item_stock_" + sizes[i]).val() != ''){
                $(".item_stock_error_msg_" + sizes[i]).slideDown('slow');
                $(".item_stock_error_msg_" + sizes[i]).html('');
            }
            if($("#product_weight_type_" + sizes[i]+" option:selected").val() != 'null'){
                $(".product_weight_type_error_msg_" + sizes[i]).slideDown('slow');
                $(".product_weight_type_error_msg_" + sizes[i]).html('');
            }
            if($("#product_price_" + sizes[i]).val() != ''){
                $(".product_price_error_msg_" + sizes[i]).slideDown('slow');
                $(".product_price_error_msg_" + sizes[i]).html('');
            }
        }
    }
});

function Check_validation(id) {
    var fileUpload = document.getElementById(id);
    var regex = new RegExp("([a-zA-Z0-9\s_\\. \-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (width < 540 || height < 600) {
                        if(id == "product_image1"){
                            $(".error_msg").eq(6).html('<i class="fa fa-info-circle"></i> This image size is small, Please upload large image.');
                            $(".error_msg").eq(6).slideDown('slow'); $("#product_image1").focus(); image1_error=true;
                        }
                        if(id == "product_image2"){
                            $(".error_msg").eq(7).html('<i class="fa fa-info-circle"></i> This image size is small, Please upload large image.');
                            $(".error_msg").eq(7).slideDown('slow'); $("#product_image2").focus(); image2_error=true;
                        }
                        if(id == "product_image3"){
                            $(".error_msg").eq(8).html('<i class="fa fa-info-circle"></i> This image size is small, Please upload large image.');
                            $(".error_msg").eq(8).slideDown('slow'); $("#product_image3").focus(); image3_error=true;
                        }
                        if(id == "product_image4"){
                            $(".error_msg").eq(9).html('<i class="fa fa-info-circle"></i> This image size is small, Please upload large image.');
                            $(".error_msg").eq(9).slideDown('slow'); $("#product_image4").focus(); image4_error=true;
                        }
                        if(id == "product_image5"){
                            $(".error_msg").eq(10).html('<i class="fa fa-info-circle"></i> This image size is small, Please upload large image.');
                            $(".error_msg").eq(10).slideDown('slow'); $("#product_image5").focus(); image5_error=true;
                        }
                    }else{

                        if(id == "product_image1"){
                            $(".error_msg").eq(6).slideDown('slow');
                            $(".error_msg").eq(6).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image1_error=false;
                        }
                        if(id == "product_image2"){
                            $(".error_msg").eq(7).slideDown('slow');
                            $(".error_msg").eq(7).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image2_error=false;
                        }
                        if(id == "product_image3"){
                            $(".error_msg").eq(8).slideDown('slow');
                            $(".error_msg").eq(8).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image3_error=false;
                        }
                        if(id == "product_image4"){
                            $(".error_msg").eq(9).slideDown('slow');
                            $(".error_msg").eq(9).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image4_error=false;
                        }
                        if(id == "product_image5"){
                            $(".error_msg").eq(10).slideDown('slow');
                            $(".error_msg").eq(10).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image5_error=false;
                        }
                    }
                    return true;
                };
            }
        } else {
            alert("This browser does not support HTML5.");
            return false;
        }
    } else {

        if(id == "product_image1"){
            $(".error_msg").eq(6).html('<i class="fa fa-info-circle"></i> Invalid Image! Please select a valid (.png, .jpg, .jpeg) Image file.');
            $(".error_msg").eq(6).slideDown('slow'); $("#product_image1").focus(); image1_error=true;
        }else {
            $(".error_msg").eq(6).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image1_error=false;
        }
        if(id == "product_image2"){
            if ($('#product_image2').get(0).files.length === 1) {

                $(".error_msg").eq(7).html('<i class="fa fa-info-circle"></i> Invalid Image! Please select a valid (.png, .jpg, .jpeg) Image file.');

                $("#product_image2").focus();
                image2_error = true;
            }else{
                $(".error_msg").eq(7).slideUp('slow');
            }
        }else {
            $(".error_msg").eq(7).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image2_error=false;
        }
        if(id == "product_image3"){
            if ($('#product_image3').get(0).files.length === 1) {

                $(".error_msg").eq(8).html('<i class="fa fa-info-circle"></i> Invalid Image! Please select a valid (.png, .jpg, .jpeg) Image file.');
                $(".error_msg").eq(8).slideDown('slow');
                $("#product_image3").focus();
                image3_error = true;
            }else{
                $(".error_msg").eq(8).slideUp('slow');
            }

        }else {
            $(".error_msg").eq(8).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>'); image3_error=false;
        }
        if(id == "product_image4"){
            if ($('#product_image4').get(0).files.length === 1) {

                $(".error_msg").eq(9).html('<i class="fa fa-info-circle"></i> Invalid Image! Please select a valid (.png, .jpg, .jpeg) Image file.');
                $(".error_msg").eq(9).slideDown('slow');
                $("#product_image4").focus();
                image4_error = true;
            }else{
                $(".error_msg").eq(9).slideUp('slow');
            }

        }else {
            $(".error_msg").eq(9).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>');
            image4_error = false;
        }
        if(id == "product_image5"){
            if ($('#product_image5').get(0).files.length === 1) {
                $(".error_msg").eq(10).html('<i class="fa fa-info-circle"></i> Invalid Image! Please select a valid (.png, .jpg, .jpeg) Image file.');
                $(".error_msg").eq(10).slideDown('slow');
                $("#product_image5").focus();
                image5_error = true;
            }else{
                $(".error_msg").eq(10).slideUp('slow');
            }
        }else {
            $(".error_msg").eq(10).html('<span class="text-success"><i class="fa fa-check-circle"></i> Valid Image.</span>');
            image5_error = false;
        }
        return false;
    }
}

function step1chk() {

    var errors=false;
    if($("#item_city option:selected").val() == 'null'){
        $(".error_msg").eq(5).html('<i class="fa fa-info-circle"></i> Please choose the item\'s city.');
        $(".error_msg").eq(5).slideDown('slow');
        $("#item_city").focus();
        errors=true;
    }
    if($("#item_country option:selected").val() == 'null'){
        $(".error_msg").eq(4).html('<i class="fa fa-info-circle"></i> Please choose the item\'s country.');
        $(".error_msg").eq(4).slideDown('slow');
        $("#item_country").focus();
        errors=true;
    }
    if($("#pro_text").val() == ''){
        $(".error_msg").eq(3).html('<i class="fa fa-info-circle"></i> Please text your item name.');
        $(".error_msg").eq(3).slideDown('slow');
        $("#pro_text").focus();
        errors=true;
    }
    if($("#m_cat option:selected").val() == 'null'){
        $(".error_msg").eq(0).html('<i class="fa fa-info-circle"></i> Please choose the item type.');
        $(".error_msg").eq(0).slideDown('slow');
        $("#m_cat").focus();
        errors=true;
    }else if($("#sub_cat option:selected").val() == "null"){
        $(".error_msg").eq(1).html('<i class="fa fa-info-circle"></i> Please choose the item category.');
        $(".error_msg").eq(1).slideDown('slow');
        $("#sub_cat").focus();
        errors=true;
    }else if($("#last_cat option:selected").val() == "null"){
        $(".error_msg").eq(2).html('<i class="fa fa-info-circle"></i> Please choose the item sub category.');
        $(".error_msg").eq(2).slideDown('slow');
        $("#last_cat").focus();
        errors=true;
    }
    return errors;
}
function step2chk(){

    var errors=false;
    if ($('#product_image1').get(0).files.length === 0) {
        $(".error_msg").eq(6).html('<i class="fa fa-info-circle"></i> Please upload item\'s image.');
        $(".error_msg").eq(6).slideDown('slow'); $("#product_image1").focus();
        errors=true;
    }else
    {
        if(image1_error == true){
            Check_validation('product_image1');
            $(".error_msg").eq(6).slideDown('slow');
            $("#product_image1").focus(); errors=true;
        }
        if ($('#product_image2').get(0).files.length === 1) {
            if(image2_error == true){ Check_validation('product_image2'); $(".error_msg").eq(7).slideDown('slow'); $("#product_image2").focus(); errors=true;}
        }
        if ($('#product_image3').get(0).files.length === 1) {

            if (image3_error == true) { Check_validation('product_image3'); $(".error_msg").eq(8).slideDown('slow'); $("#product_image3").focus(); errors = true;}
        }
        if ($('#product_image4').get(0).files.length === 1) {
            if (image4_error == true) { Check_validation('product_image4'); $(".error_msg").eq(9).slideDown('slow'); $("#product_image4").focus(); errors = true;}
        }
        if ($('#product_image5').get(0).files.length === 1) {

            if (image5_error == true) { Check_validation('product_image5'); $(".error_msg").eq(10).slideDown('slow'); $("#product_image5").focus(); errors = true;}
        }
    }
    return errors;
}

function step3chk(){

    var errors=false;
    if($("#item_condition option:selected").val() == 'null'){
        $(".error_msg").eq(11).html('<small><i class="fa fa-info-circle"></i> Please choose the item\'s condition info.<small>');
        $(".error_msg").eq(11).slideDown('slow');
        $("#item_condition").focus();
        errors=true;
    }

    if($("#product_advance_pricing").val() == 1){
        var str = $("#p_sizes").val();
        var sizes = str.split(",");
        if (sizes[0] != "") {
            for (var i = 0; i < sizes.length; i++) {
                if($("#product_price_" + sizes[i]).val() == ''){
                    $(".product_price_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Item price required.</small>');
                    $(".product_price_error_msg_" + sizes[i]).slideDown('slow');
                    $("#product_price_" + sizes[i]).focus();
                    errors=true;
                }
                if($("#item_company_percentage_" + sizes[i]).val() == ''){
                    $(".item_company_percentage_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> My Percentage required.</small>');
                    $(".item_company_percentage_error_msg_" + sizes[i]).slideDown('slow');
                    $("#item_company_percentage_" + sizes[i]).focus();
                    errors=true;
                }
                if($("#item_stock_" + sizes[i]).val() == ''){
                    $(".item_stock_error_msg_" + sizes[i]).html('<small><i class="fa fa-info-circle"></i> Item stock required.</small>');
                    $(".item_stock_error_msg_" + sizes[i]).slideDown('slow');
                    $("#item_stock_" + sizes[i]).focus();
                    errors=true;
                }
            }
        }

    }else{

        if($("#product_price").val() == ''){
            $(".error_msg").eq(12).html('<small><i class="fa fa-info-circle"></i> Item price required.</small>');
            $(".error_msg").eq(12).slideDown('slow');
            $("#product_price").focus();
            errors=true;
        }
        if($("#product_company_percentage").val() == ''){
            $(".error_msg").eq(13).html('<small><i class="fa fa-info-circle"></i> My Percentage required.</small>');
            $(".error_msg").eq(13).slideDown('slow');
            $("#product_company_percentage").focus();
            errors=true;
        }
        if($("#stock_count").val() == ''){
            $(".error_msg").eq(15).html('<small><i class="fa fa-info-circle"></i> Item stock required.</small>');
            $(".error_msg").eq(15).slideDown('slow');
            $("#stock_count").focus();
            errors=true;
        }
    }
    return errors;
}


$(".check_validation_by_number").click(function(){

    var types=$(this).attr('data-type');
    if(types == "item_info"){

        if(step1chk() == true){
            return false;
        }
    }
    if(types == "item_image"){

        if(step1chk() == true){
            return false;
        }
        if(step1chk() == false && step2chk() == true){
            $(".step_2").click();
            return false;
        }

    }else if(types == "item_preference"){

        if(step1chk() == true){
            return false;
        }

        if(step1chk() == false && step2chk() == true){
            $(".step_2").click();
            return false;
        }

        if(step1chk() == false && step2chk() == false && step3chk() == true){
            $(".step_3").click();
            return false;
        }
    }
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
$('.nav-tabs').on('click', 'li', function () {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});