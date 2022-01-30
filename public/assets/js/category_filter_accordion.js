//----------------------------------------
// Breadcrumbs
//----------------------------------------
$('.breadcrumbs li a').each(function(){
    var breadWidth = $(this).width();
    if($(this).parent('li').hasClass('active') || $(this).parent('li').hasClass('first')){
    } else {
        $(this).css('width', 75 + 'px');
        $(this).mouseover(function(){
            $(this).css('width', breadWidth + 'px');
        });
        $(this).mouseout(function(){
            $(this).css('width', 75 + 'px');
        });
    }
});
var acc = document.getElementsByClassName("accordion-cus");
var i;
for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("accordion-active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}
acc[0].click();
acc[1].click();
acc[2].click();
acc[3].click();
