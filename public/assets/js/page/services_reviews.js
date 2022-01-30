$(document).ready(function () {
    $("#show_value").hide();
    $("#btn_show").click(function () {
        $("#hided_value").hide();
        $("#show_value").show();
    });
    $("#btn_hide").click(function () {
        $("#hided_value").show();
        $("#show_value").hide();
    });
    $(".product_body").shorten({
        "showChars": 150,
        "moreText": "See More <i class=\"fa fa-chevron-down\" aria-hidden=\"true\"></i>",
        "lessText": "Less <i class=\"fa fa-chevron-up\" aria-hidden=\"true\"></i>",
    });
    $('#review_rate span').click(function () {
        var get_value = $(this).attr('data-value');
        $("#inputRateValue").val(get_value);
    });
    $(document).on('click', '#show_more', function (event) {
        event.preventDefault();
        var id = $("#service_id").val();
        var row_count = Number($('#row').val());
        var all_count = Number($('#all_reviews_count').val());
        var rowperpage = 2;
        row_count = row_count + rowperpage;
        $("#row").val(row_count);
        $.ajax({
            url: "/clinique/reviews/fetch/load_more?service_id=" + id + "&row_count=" + row_count,
            method: "GET",
            beforeSend: function () {
                $("#show_more").text("Loading...");
            },
            success: function (data) {
                setTimeout(function () {
                    $('.review_data').empty().html(data);
                    if (row_count > all_count) {
                        $('#show_more').hide();
                        $(".finished_data").fadeIn();
                    } else {
                        $("#show_more").text("Load more");
                    }
                }, 500);
            }
        });
    });
});
