$(document).ready(function () {
    $(document).on('click', '.remove_comparison_item', function(event){
        event.preventDefault();
        var product_row_id=$(this).attr("data-row-id");
        var key_id=$(this).attr("data-key-id");
        swal({
            title: "Remove?",
            text: "Are you sure want to remove this product from your comparison list?",
            icon: "warning",
            buttons: ["No thanks!", "Oh! Yes"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:"/product/comparison/remove-item",
                        method: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:{ id: product_row_id},
                        success: function (data) {
                            if(data['status']=="success"){
                                $(".row_key_"+key_id).fadeOut();
                                if(data['comparison_count']==0){
                                    $(".compare_box").fadeOut();
                                    $(".show_empty_list").fadeIn();
                                }
                                $(".comparison_item_count").html(data['comparison_count']);
                            }else{
                                swal("OPP's!", "There was problem, Please try again later", "info");
                            }
                        }
                    });
                } else { }
            });
    });
    $(document).on('click', '.remove_comparison_all_item', function(event){
        event.preventDefault();
        swal({
            title: "Remove All?",
            text: "Are you sure want to clear all comparision products?",
            icon: "warning",
            buttons: ["No thanks!", "Oh! Yes"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:"/product/comparison/remove-all-item",
                        method: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:{},
                        success: function (data) {
                            if(data['status']=="success"){
                                $(".compare_box").fadeOut();
                                $(".show_empty_list").fadeIn();
                                $(".comparison_item_count").html(data['comparison_count']);
                            }else{
                                swal("OPP's!", "There was problem, Please try again later", "info");
                            }
                        }
                    });
                } else {  }
            });
    });
});
