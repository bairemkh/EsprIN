"use strict";
/*! friends.js | Friendkit | © Css Ninja. 2019-2020 */
$(document).ready((function () {
    if ($("#friends-page").length) {
        $(".subloader").removeClass("is-active"), initComboBox(), initImageComboBox(), $(".friend-card").addClass("textFilter-target"), $(".friend-card").find(" .friend-info h3,  .friend-info p").addClass("textFilter-match"), initTextFilter(), $(".option-tabs.is-friends .option-tab").on("click", (function () {
            var i;
            i = 800, $(".subloader").addClass("is-active"), setTimeout((function () {
                $(".subloader").removeClass("is-active")
            }), i);
            var t = $(this).attr("data-tab");
            $(this).siblings(".option-tab").removeClass("is-active"), $(this).addClass("is-active"), setTimeout((function () {
                $(".card-row-wrap").removeClass("is-active"), $("#" + t).addClass("is-active")
            }), 200)
        })), $(".star-friend").on("click", (function () {
            $(this).toggleClass("is-active")
        }))
    }
}));