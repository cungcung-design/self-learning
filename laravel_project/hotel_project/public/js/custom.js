$(function () {
    "use strict";

    $(window).on("load", function () {
        $(".loader_bg").fadeOut(200);
    });

    setTimeout(function () {
        $(".loader_bg").fadeOut(200);
    }, 400);

    $('[data-toggle="tooltip"]').tooltip();

    $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $(this).toggleClass("active");
    });
});
