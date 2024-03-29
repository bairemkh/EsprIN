/*! sidebar-v1.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";

function openSidebarV1() {
    $(".sidebar-v1-trigger").find(".icon-box-toggle").addClass("active"), $(".sidebar-v1, .view-wrapper, .toolbar-v1-fixed-wrap").removeClass("is-fold")
}

function closeSidebarV1() {
    $(".sidebar-v1-trigger").find(".icon-box-toggle").removeClass("active"), $(".sidebar-v1, .view-wrapper, .toolbar-v1-fixed-wrap").addClass("is-fold")
}

function initSidebarV1() {
    if ($(".sidebar-v1").length) {
        if ($(".sidebar-v1-trigger").on("click", (function () {
            $(".sidebar-v1-trigger").find(".icon-box-toggle").toggleClass("active"), $(".sidebar-v1, .view-wrapper, .toolbar-v1-fixed-wrap").toggleClass("is-fold")
        })), $("#sidebar-v1-close").on("click", (function () {
            $(".sidebar-v1-trigger .icon-box-toggle").toggleClass("active"), $(".sidebar-v1, .view-wrapper, .toolbar-v1-fixed-wrap").toggleClass("is-fold")
        })), $("*[data-open-sidebar]").length && window.matchMedia("(min-width: 768px)").matches && window.matchMedia("(orientation: landscape)").matches && openSidebarV1(), $("*[data-page-title]").length) {
            var i = $("[data-page-title]").attr("data-page-title");
            $(".toolbar-v1 h1").html(i)
        }
        $(window).on("resize", (function () {
            window.matchMedia("(max-width: 768px)").matches ? window.matchMedia("(orientation: portrait)").matches && closeSidebarV1() : window.matchMedia("(orientation: landscape)").matches && openSidebarV1()
        })), $(window).on("scroll", (function () {
            $(window).scrollTop() > 80 ? $(".toolbar-v1-fixed-wrap").addClass("is-active") : $(".toolbar-v1-fixed-wrap").removeClass("is-active")
        }));
        var e = window.location.href;
        "" == (e = (e = (e = e.substring(0, -1 == e.indexOf("#") ? e.length : e.indexOf("#"))).substring(0, -1 == e.indexOf("?") ? e.length : e.indexOf("?"))).substr(e.lastIndexOf("/") + 1)) && (e = "index.html"), $(".sidebar-v1 .bottom-section a").removeClass("is-active"), $(".sidebar-v1 .bottom-section a").each((function () {
            var i = $(this).attr("href");
            e == i && $(this).addClass("is-active")
        }))
    }
}