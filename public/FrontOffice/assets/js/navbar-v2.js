/*! navbar-mobile.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";

function initNavbarV2() {
    if ($(".navbar-v2").length) {
        $("#open-mobile-search, .mobile-search .close-icon").on("click", (function () {
            $(".mobile-search .input").val(""), $(".top-nav").find(".left, .right, .mobile-search").toggleClass("is-hidden"), $(".mobile-search .input").focus()
        }));
        var i = window.location.href;
        "" == (i = (i = (i = i.substring(0, -1 == i.indexOf("#") ? i.length : i.indexOf("#"))).substring(0, -1 == i.indexOf("?") ? i.length : i.indexOf("?"))).substr(i.lastIndexOf("/") + 1)) && (i = "index.html"), $(".sub-nav li").removeClass("is-active"), $(".sub-nav a").each((function () {
            var e = $(this).attr("href");
            i == e && $(this).closest("li").addClass("is-active")
        }))
    }
}

$(document).ready((function () {
}));