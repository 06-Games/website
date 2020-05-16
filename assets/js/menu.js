$(window).on('hashchange', function () {
    changeMenu(window.location.hash);
    $('html,body').scrollTop(0);
});
$(document).ready(function () { language(lang); });

var lang = Cookies.get('lang');
if (lang == null) lang = "en";
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

function language(val) {
    lang = val;
    Cookies.set('lang', val, { sameSite: 'Lax' });
    $("footer").load("pages/" + lang + "/footer.html");
    $(".main-menu").load("pages/" + lang + "/menu.html", function () {
        if (window.location.hash) {
            changeMenu(window.location.hash);
            $('html,body').scrollTop(0);
        }
        else window.location.hash = "#Home";
    });
}