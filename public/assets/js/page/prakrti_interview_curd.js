$(document).ready(function() {
    'use strict';
    $('.test-step .button--next').on('click', function(e) {
        e.preventDefault();
        var error=false;
        var id = $(this).attr('data-row-id');
        var qIds=$("#question-ids-"+id).val();
        var loop_ids=$("#answer-loop-ids-"+id).val();
        if(qIds){
            var id_array=qIds.split(',');
            var id_loop_array=loop_ids.split(',');
            for(var i=0; i<(id_array.length-1); i++){
                if(get_filter('que-answers-'+id_array[i]) == ""){
                    error=true;
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: "<span class='text-uppercase'>Required <span class='text-lowercase'>("+numberOrdinal(id_loop_array[i])+")</span> Question Answer</span>",
                        text: "Please choose an answer option to continue",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
            if(error ==false){
                $('html, body').animate({
                    scrollTop: ($(".question_slot_scroll").offset().top - 120)
                }, 1000);
                $(this).parents('.test-step').next().addClass('active');
                $(this).parents('.test-step').removeClass('active');
                var delayInMilliseconds = 9000; //9 second
                if($(this).parents('.test-step').next().attr('data-last-step')){
                    setTimeout(function() {
                        $(".submit-answer").click();
                    }, delayInMilliseconds);

                }
            }
        }
    });
    $(".common_answers").click(function(){
        var count=0; var all_que_ids=$("#all_que_ids").val(); var id_array=all_que_ids.split(',');
        for(var i=0; i<(id_array.length-1); i++){ if(get_filter('que-answers-'+id_array[i]) != ""){ count++; } }
        var type_array = get_type('common_answers');
        var result = type_array.reduce((r,c) => (r[c] = (r[c] || 0) + 1, r), {});
        if(result['Vata']){
            var progress = (result['Vata']/parseInt($('#que_count_all').val())*100);
            $(".vata-progress-count").html(progress.toFixed(0)+"%"); $("#vata-counts").val(progress.toFixed(0));
        }else{ $(".vata-progress-count").html("0%"); $("#vata-counts").val(progress);}
        if(result['Pitta']){
            var progress = (result['Pitta']/parseInt($('#que_count_all').val())*100);
            $(".pitta-progress-count").html(progress.toFixed(0)+"%"); $("#pitta-counts").val(progress.toFixed(0));
        }else{ $(".pitta-progress-count").html("0%"); $("#pitta-counts").val(0);}
        if(result['Kapha']){
            var progress = (result['Kapha']/parseInt($('#que_count_all').val())*100);
            $(".kapha-progress-count").html(progress.toFixed(0)+"%"); $("#kapha-counts").val(progress.toFixed(0));
        }else{ $(".kapha-progress-count").html("0%"); $("#kapha-counts").val(0); }
        $(".question-progress-count").html(count+"/"+$('#que_count_all').val());
        $("#answered_count_all").val(count);
    });
    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }
    function get_type(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function () {
            filter.push($(this).attr('data-type'));
        });
        return filter;
    }
    function numberOrdinal(dom) {
        if (dom == 31 || dom == 21 || dom == 1) return dom + "st";
        else if (dom == 22 || dom == 2) return dom + "nd";
        else if (dom == 23 || dom == 3) return dom + "rd";
        else return dom + "th";
    }
    $('.test-step .prev-btn').on('click', function(e) {
        e.preventDefault();
        $(this).parents('.test-step').prev().addClass('active');
        $(this).parents('.test-step').removeClass('active');
    });
    $(".submit-answer").click(function(){
        $("#selected_answers").val(get_filter('common_answers'));
        $("#question-form").submit();
        //:Check gender
        // if($("input:radio[name='user_gender']").is(":checked")) {
        //
        // }else{
        //     Swal.fire({
        //         type: 'warning',
        //         icon: 'warning',
        //         title: "<span class='text-uppercase'>Required Gender</span>",
        //         text: "Please choose your gender and submit your answers.",
        //         showConfirmButton: false,
        //         timer: 2000
        //     });
        // }
    });
    $("#send-answer-copy").click(function(){
        //window.location.href='/prakrti-parīksha/send-answer-copy';
        $.ajax({
            url:"/prakrti-parīksha/send-answer-copy",
            method: "POST",
            data:{},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if(data == "success"){
                    Swal.fire({
                        type: 'info',
                        icon: 'info',
                        title: "<span class='text-uppercase'>DONE!</span>",
                        text: "A copy of your result has been sent to your email.",
                        showConfirmButton: true,
                        timer: 3000
                    });
                }else{
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: "<span class='text-uppercase'>Failed Send Answer</span>",
                        text: "Please contact with our customer care and send your copy of your answer.",
                        showConfirmButton: true,
                        timer: 3000
                    });
                }
            }
        });
    });
});
