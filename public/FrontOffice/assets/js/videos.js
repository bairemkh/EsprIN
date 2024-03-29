"use strict";
/*! videos.js | Friendkit | © Css Ninja. 2019-2020 */
$(document).ready((function () {
    if ($(".videos-sidebar").length) {
        var e = function () {
            window.matchMedia("(max-width: 767px)").matches || window.matchMedia("(max-width: 768px)").matches ? $(".videos-sidebar").removeClass("is-active") : $(".videos-sidebar").addClass("is-active")
        };
        $(".mobile-sidebar-trigger").on("click", (function () {
            $(".videos-sidebar").addClass("is-active")
        })), $(".close-videos-sidebar").on("click", (function () {
            $(this).closest(".videos-sidebar").removeClass("is-active")
        })), e(), $(window).on("resize", (function () {
            e()
        }))
    }
    $(".related-side").length && ($(".related-trigger").on("click", (function () {
        $(".related-side").addClass("is-opened")
    })), $(".close-related-videos").on("click", (function () {
        $(".related-side").removeClass("is-opened")
    }))), $(".videos-wrapper.is-home").length && $(".video-header-wrap").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: !0,
        autoplay: !0,
        autoplaySpeed: 8e3,
        fade: !0,
        dots: !0,
        pauseOnFocus: !0,
        arrows: !1,
        prevArrow: "<div class='slick-custom is-prev'><i class='fa fa-chevron-left'></i></div>",
        nextArrow: "<div class='slick-custom is-next'><i class='fa fa-chevron-right'></i></div>"
    }), $(".videos-wrapper.has-player").length && ($("#description-show-more").on("click", (function () {
        $(".additional-description").slideToggle("fast"), "Show More" == $(this).text() ? $(this).html("Show Less") : $(this).html("Show More")
    })), $(".nested-replies .header").on("click", (function () {
        $(this).toggleClass("is-active"), $(this).siblings(".nested-comments").slideToggle("fast")
    })))
}));