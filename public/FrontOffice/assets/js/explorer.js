"use strict";
/*! explorer.js | Friendkit | © Css Ninja. 2019-2020 */
$(document).ready((function () {
    $(".explorer-menu").length && $("#explorer-trigger, #mobile-explorer-trigger").on("click", (function () {
        $(".explorer-menu").toggleClass("is-active")
    }))
}));