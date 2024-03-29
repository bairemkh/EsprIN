/*! navbar-options.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";

function initSubSearch() {
    $("#show-subsearch, #hide-subsearch").length && $("#show-subsearch, #hide-subsearch").on("click", (function () {
        $("#show-subsearch, #hide-subsearch, #subsearch").toggleClass("is-hidden"), $("#subsearch input").focus()
    }))
}

function initSidebar() {
    $("#show-filters, #hide-filters").length && $("#show-filters, #hide-filters").on("click", (function () {
        $("#show-filters, #hide-filters").toggleClass("is-hidden"), $(".filters-panel").toggleClass("is-active"), $(".main-container").toggleClass("has-sidebar")
    }))
}

$(document).ready((function () {
    initSubSearch(), initSidebar()
}));