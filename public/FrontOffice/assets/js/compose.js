/*! compose.js | Friendkit | © Css Ninja. 2019-2021 */
"use strict";

function openFriendsDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#feed-users-autocpl").focus(), $("#feed-users-autocpl").attr("value", ""), $("#feed-users-autocpl").triggerHandler(e)
}

function openActivitiesDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#activities-autocpl").focus(), $("#activities-autocpl").attr("value", ""), $("#activities-autocpl").triggerHandler(e)
}

function openMoodDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#mood-autocpl").focus(), $("#mood-autocpl").attr("value", ""), $("#mood-autocpl").triggerHandler(e)
}

function openDrinksDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#drinking-autocpl").focus(), $("#drinking-autocpl").attr("value", ""), $("#drinking-autocpl").triggerHandler(e)
}

function openEatsDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#eating-autocpl").focus(), $("#eating-autocpl").attr("value", ""), $("#eating-autocpl").triggerHandler(e)
}

function openReadsDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#reading-autocpl").focus(), $("#reading-autocpl").attr("value", ""), $("#reading-autocpl").triggerHandler(e)
}

function openWatchDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#watching-autocpl").focus(), $("#watching-autocpl").attr("value", ""), $("#watching-autocpl").triggerHandler(e)
}

function openTravelDrop() {
    var e = $.Event("keyup", {keyCode: 65, which: 65});
    $("#travel-autocpl").focus(), $("#travel-autocpl").attr("value", ""), $("#travel-autocpl").triggerHandler(e)
}

function readURL(e) {
    if (e.files && e.files[0]) {
        var i = new FileReader;
        i.onload = function (e) {
            var i = feather.icons.x.toSvg(),
                t = '\n                <div class="upload-wrap">\n                    <img src="' + e.target.result + '" alt="">\n                    <span class="remove-file">\n                        ' + i + "\n                    </span>\n                </div>\n            ";
            $("#feed-upload").append(t), $("#feed-upload-input-1, #feed-upload-input-2").attr("disabled", !0), $(".remove-file").on("click", (function () {
                $("#feed-upload-input-1, #feed-upload-input-2").val("").attr("disabled", !1), $(this).closest(".upload-wrap").remove()
            }))
        }, i.readAsDataURL(e.files[0])
    }
}

function albumsHelp() {
    $("#albums-help-modal .next-modal").one("click", (function () {
        $(this).closest(".card-body").find(".content-block, .dot").toggleClass("is-active"), $(this).text("got it").off(), endAlbumHelp()
    }))
}

function endAlbumHelp() {
    $("#albums-help-modal .next-modal").on("click", (function () {
        var e = $(this), i = e.attr("data-modal");
        e.closest(".modal").removeClass("is-active"), $("#" + i).addClass("is-active"), setTimeout((function () {
            e.closest(".card-body").find(".content-block, .dot").toggleClass("is-active"), e.text("Next").off(), albumsHelp()
        }), 800)
    }))
}

function videosHelp() {
    $("#videos-help-modal .next-modal").one("click", (function () {
        $(this).closest(".card-body").find(".content-block, .dot").toggleClass("is-active"), $(this).text("got it").off(), endVideoHelp()
    }))
}

function endVideoHelp() {
    $("#videos-help-modal .next-modal").on("click", (function () {
        var e = $(this), i = $(this).attr("data-modal");
        e.closest(".modal").removeClass("is-active"), window.matchMedia("(orientation: portrait)").matches ? $("#no-stream-modal").addClass("is-active") : $("#" + i).addClass("is-active"), setTimeout((function () {
            e.closest(".card-body").find(".content-block, .dot").toggleClass("is-active"), e.text("Next").off(), videosHelp()
        }), 800)
    }))
}

$("#compose-card").length && ($("#publish").on("click", (function () {
    $(".app-overlay").addClass("is-active"), $(".is-new-content").addClass("is-highlighted")
})), $("#add-story-button").on("click", (function () {
    $(".app-overlay").addClass("is-active"), $(".is-new-content").addClass("is-highlighted"), $(".target-channels .channel").each((function () {
        $(this).find('input[type="checkbox"]').prop("checked") ? $(this).find('input[type="checkbox"]').prop("checked", !1) : $(this).find('input[type="checkbox"]').prop("checked", !0)
    }))
})), $("#publish").on("input", (function () {
    $(this).val().length >= 1 ? $("#publish-button").removeClass("is-disabled") : $("#publish-button").addClass("is-disabled")
})), $(".close-publish").on("click", (function () {
    $(".app-overlay").removeClass("is-active"), $(".is-new-content").removeClass("is-highlighted"), $("#compose-search, #extended-options, .is-suboption").addClass("is-hidden"), $("#basic-options, #open-compose-search").removeClass("is-hidden")
})), $("#show-compose-friends").on("click", (function () {
    $(this).addClass("is-hidden"), $(".friends-list").removeClass("is-hidden"), $(".hidden-options").addClass("is-opened")
})), $("#open-extended-options").on("click", (function () {
    $(".app-overlay").addClass("is-active"), $(".is-new-content").addClass("is-highlighted"), $(".compose-options").toggleClass("is-hidden")
})), $("#open-compose-search").on("click", (function () {
    $("#compose-search, #open-compose-search").toggleClass("is-hidden")
})), $(".channel, .friend-block").on("click", (function (e) {
    if (e.target !== this) return !1;
    $(this).find('input[type="checkbox"]').prop("checked") ? $(this).find('input[type="checkbox"]').prop("checked", !1) : $(this).find('input[type="checkbox"]').prop("checked", !0)
})), $("#open-tag-suboption").on("click", (function () {
    $(".is-suboption").addClass("is-hidden"), $("#tag-suboption").removeClass("is-hidden"), openFriendsDrop()
})), $("#show-activities, #extended-show-activities").on("click", (function () {
    $(".app-overlay").addClass("is-active"), $(".is-new-content").addClass("is-highlighted"), $(".is-suboption").addClass("is-hidden"), $("#activities-suboption").removeClass("is-hidden"), openActivitiesDrop()
})), $(".input-block, .close-icon.is-subactivity").on("click", (function () {
    $("#activities-autocpl-wrapper").toggleClass("is-hidden"), $(".is-activity").addClass("is-hidden"), $(".easy-autocomplete-container li").removeClass("selected"), $(".mood-display").html(""), openActivitiesDrop()
})), $("#open-location-suboption").on("click", (function () {
    $(".is-suboption").addClass("is-hidden"), $("#location-suboption").removeClass("is-hidden")
})), $("#open-link-suboption").on("click", (function () {
    $(".is-suboption").addClass("is-hidden"), $("#link-suboption").removeClass("is-hidden")
})), $("#open-gif-suboption").on("click", (function () {
    $(".is-suboption").addClass("is-hidden"), $("#gif-suboption").removeClass("is-hidden")
})), $(".is-autocomplete .close-icon.is-main").on("click", (function () {
    $(this).closest(".is-suboption").addClass("is-hidden")
})), initPostComments(), $("#new-group-list .friend-block").on("click", (function () {
    var e = $(this).closest(".friend-block").attr("data-ref"),
        i = $(this).closest(".friend-block").find("img").attr("src"),
        t = $(this).closest(".friend-block").find(".friend-name").text(), o = feather.icons.check.toSvg(), s = "";
    if ($(this).find("input").prop("checked")) {
        if ($("#" + e).length) return !1;
        s = '\n                    <div id="' + e + '" class="selected-friend-block">\n                        <div class="image-wrapper">\n                            <img class="friend-avatar" src="' + i + '" alt="">\n                            <div class="checked-badge">\n                                ' + o + '\n                            </div>\n                        </div>\n                        <div class="friend-name">' + t + "</div>\n                    </div>\n                ", $("#selected-list").append(s);
        var n = $("#selected-list .selected-friend-block").length;
        $("#selected-friends-count").html(n)
    } else {
        console.log("it has been unchecked!"), $("#" + e).remove();
        n = $("#selected-list .selected-friend-block").length;
        $("#selected-friends-count").html(n)
    }
})), albumsHelp(), $("#tagged-in-album button").on("click", (function () {
    $(this).addClass("is-hidden"), $(this).closest(".tagged-in-album").find(".field, p").toggleClass("is-hidden")
})), $("#album-date button").on("click", (function () {
    $(this).addClass("is-hidden"), $(this).closest(".album-date").find("p").addClass("is-hidden"), $(this).closest(".album-date").find(".control").removeClass("is-hidden")
})), $("#album-datepicker").datepicker({
    format: "mm-dd-yyyy",
    container: "body",
    autoHide: !0,
    offset: 0
}), videosHelp());