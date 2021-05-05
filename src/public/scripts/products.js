$(document).ready(function(){

    $("div.product-image").mouseenter(function () {
        $(this).find(".buy").slideToggle(200);
    })

    $("div.product-image").mouseleave(function () {
        $(this).find(".buy").slideToggle(200);
    })

});