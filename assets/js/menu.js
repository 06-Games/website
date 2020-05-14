$(window).on('hashchange', function () {
    changeMenu(window.location.hash);
    $('html,body').scrollTop(0);
});
$(document).ready(function () {
    if (window.location.hash) {
        changeMenu(window.location.hash);
        $('html,body').scrollTop(0);
    }
    else window.location.hash = "#Home";
});

var lang = "en";
function changeMenu(id) {
    $('.main-menu > a[href="' + id + '"]').addClass('selected');
    $('.main-menu > a:not([href="' + id + '"])').removeClass('selected');

    $(".page .loading").show();
    $(".page .content").fadeOut(500, function () {
        $(this).empty().load("pages/" + lang + "/" + id.substr(1).toLowerCase() + ".html", function () {
            $(".page .loading").hide();
            $(".page .content").fadeIn(500);
        });
    });
}

function fr() {
    lang = "fr";
    changeMenu(window.location.hash);
}