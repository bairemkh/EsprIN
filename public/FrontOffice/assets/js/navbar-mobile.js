/*! navbar-mobile.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";

function initResponsiveMenu() {
    $(".navbar-burger").length && ($(".navbar-burger").on("click", (function () {
        $(this).toggleClass("is-active"), $(".navbar-menu").hasClass("is-active") ? $(".navbar-menu").removeClass("is-active") : $(".navbar-menu").addClass("is-active")
    })), $("#open-mobile-search, .mobile-search .close-icon").on("click", (function () {
        $(".mobile-search .input").val(""), $(".mobile-navbar").find(".navbar-brand, .navbar-menu, .mobile-search").toggleClass("is-hidden"), $(".mobile-search .input").focus()
    })))
}

$(document).ready((function () {
}));