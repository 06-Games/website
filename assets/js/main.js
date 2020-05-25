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
        $(this).empty().load("pages/" + lang + "/" + id.substr(1).toLowerCase(), function () {
            $(".page .loading").hide();
            $(".page .content").fadeIn(500);
        });
    });
}

function language(val) {
    lang = val;
    Cookies.set('lang', val, { sameSite: 'Lax', expires: 365 });
    $("footer").load("pages/" + lang + "/.footer.html");
    $(".main-menu").load("pages/" + lang + "/.menu.html", function () {
        if (window.location.hash) {
            changeMenu(window.location.hash);
            $('html,body').scrollTop(0);
        }
        else window.location.hash = "#Home";
    });

}

function registerSideMenu(contentDiv) {
    $(contentDiv).on("scroll", onScroll);
    $menu = $(contentDiv).siblings(".side-menu");

    $menu.find('button').on('click', function (e) {
        e.preventDefault();
        $(contentDiv).off("scroll");

        $menu.find('button').removeClass('active');
        $(this).addClass('active');

        $target = $(contentDiv).find($(this).attr('href'));
        $(contentDiv).stop().animate({ scrollTop: $(contentDiv).scrollTop() + $target.position().top - 26.72 }, 400, 'swing', function () {
            $(contentDiv).on("scroll", onScroll);
        });
    });

    function onScroll(event) {
        var scrollPos = $(contentDiv).scrollTop() + 26.72;
        var minPos = $(contentDiv).height();
        $menu.find('button').each(function () {
            var yPos = $(contentDiv).find($(this).attr('href')).find('h2').position().top;

            if (yPos >= 0 && yPos < $(contentDiv).height() && minPos > yPos) {
                $menu.find('button').removeClass("active");
                $(this).addClass("active");
                minPos = yPos;
            }
        });
    }

    $menu.find(".openBtn").click(function () {
        var open = $menu.offset().left < 0;
        $menu.animate({ "left": open ? "+=300px" : "-=300px" });
        $(this).text(open ? "<" : ">");
    });
}

function registerGalery($galeries) {
    $galeries.each(function (i) {
        var galery = $(this);
        galery.attr('id', galery.parent().attr('id') + "-slide");
        var figure = galery.children('figure');
        figure.attr('id', galery.attr('id') + "Fig");
        setTimeout(function () {
            cssSlidy({ slidyContainerSelector: ('#' + galery.attr('id')), slidySelector: ('#' + figure.attr('id')), captionSource: 'alt' });
        }, 100 * i);
    });
}