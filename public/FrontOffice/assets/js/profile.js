"use strict";
/*! profile.js | Friendkit | © Css Ninja. 2019-2020 */
$(document).ready((function () {
    if ($(".profile-menu").length) {
        var e = window.location.href;
        "" == (e = (e = (e = e.substring(0, -1 == e.indexOf("#") ? e.length : e.indexOf("#"))).substring(0, -1 == e.indexOf("?") ? e.length : e.indexOf("?"))).substr(e.lastIndexOf("/") + 1)) && (e = "index.html"), $(".profile-menu a").each((function () {
            var i = $(this).attr("href");
            e == i && $(this).addClass("is-active")
        }))
    }
    if ($(".avatar-button").on("click", (function () {
        $(this).toggleClass("is-active"), $(".pop-button").toggleClass("is-active")
    })), $(".pop-button").on("click", (function () {
        $(".pop-button, .avatar-button").toggleClass("is-active"), "follow-pop" == $(this).attr("id") ? $(this).hasClass("is-shifted") ? ($(this).removeClass("is-shifted"), iziToast.show({
            maxWidth: "280px",
            class: "success-toast",
            icon: "mdi mdi-bell-off",
            title: "",
            message: "You are not following Jenna anymore",
            titleColor: "#fff",
            messageColor: "#fff",
            iconColor: "#fff",
            backgroundColor: "#7F00FF",
            progressBarColor: "#b975ff",
            position: "bottomRight",
            transitionIn: "fadeInUp",
            close: !1,
            timeout: 2500,
            zindex: 99999
        })) : ($(this).addClass("is-shifted"), iziToast.show({
            maxWidth: "280px",
            class: "success-toast",
            icon: "mdi mdi-bell-ring",
            title: "",
            message: "You are now following Jenna",
            titleColor: "#fff",
            messageColor: "#fff",
            iconColor: "#fff",
            backgroundColor: "#7F00FF",
            progressBarColor: "#b975ff",
            position: "bottomRight",
            transitionIn: "fadeInUp",
            close: !1,
            timeout: 2500,
            zindex: 99999
        })) : "invite-pop" == $(this).attr("id") ? $(this).hasClass("is-shifted") ? ($(this).removeClass("is-shifted"), iziToast.show({
            maxWidth: "280px",
            class: "success-toast",
            icon: "mdi mdi-heart-broken",
            title: "",
            message: "You are no longer friends with Jenna",
            titleColor: "#fff",
            messageColor: "#fff",
            iconColor: "#fff",
            backgroundColor: "#7F00FF",
            progressBarColor: "#b975ff",
            position: "bottomRight",
            transitionIn: "fadeInUp",
            close: !1,
            timeout: 2500,
            zindex: 99999
        })) : ($(this).addClass("is-shifted"), iziToast.show({
            maxWidth: "280px",
            class: "success-toast",
            icon: "mdi mdi-send",
            title: "",
            message: "Your invitation has been sent to Jenna",
            titleColor: "#fff",
            messageColor: "#fff",
            iconColor: "#fff",
            backgroundColor: "#7F00FF",
            progressBarColor: "#b975ff",
            position: "bottomRight",
            transitionIn: "fadeInUp",
            close: !1,
            timeout: 2500,
            zindex: 99999
        })) : "chat-pop" == $(this).attr("id") && ($(".chat-wrapper").toggleClass("is-active"), $("body").toggleClass("is-frozen"))
    })), $(".change-cover-modal .selection-box, .change-profile-pic-modal .selection-box").on("click", (function () {
        $(this).closest(".modal").removeClass("is-active")
    })), $(".album-wrapper").on("click", (function () {
        var e = $(this).attr("data-album");
        $(".albums-grid").addClass("is-hidden"), void 0 !== e && ($(".album-image-grid").addClass("is-hidden"), $("#" + e).removeClass("is-hidden"))
    })), $("#upload-cover").length) {
        var i = $("#upload-cover").croppie({
            enableExif: !0,
            url: "assets/img/demo/placeholder.png",
            viewport: {width: 640, height: 184, type: "square"},
            boundary: {width: "100%", height: 300}
        });
        $("#upload-cover-picture").on("change", (function () {
            !function (e) {
                if (e.files && e.files[0]) {
                    var o = new FileReader;
                    o.onload = function (e) {
                        i.croppie("bind", {url: e.target.result}).then((function () {
                            e.target.result, console.log("jQuery bind complete")
                        }))
                    }, o.readAsDataURL(e.files[0])
                } else swal("Sorry - you're browser doesn't support the FileReader API")
            }(this), $(this).closest(".modal").find(".cover-uploader-box, .upload-demo-wrap, .cover-reset").toggleClass("is-hidden"), $("#submit-cover-picture").removeClass("is-disabled")
        })), $("#submit-cover-picture").on("click", (function (e) {
            $(this).addClass("is-loading"), i.croppie("result", {type: "canvas", size: "original"}).then((function (e) {
                var i, o;
                console.log("RESP:", e), (i = {src: e}).html && (o = i.html, console.log("HTML RESULT", o)), i.src && (o = '<img src="' + i.src + '" />', console.log(o), $(".cover-image").attr("src", i.src), $("#submit-cover-picture").removeClass("is-loading"), $("#upload-crop-cover-modal").removeClass("is-active"))
            }))
        })), $("#cover-upload-reset").on("click", (function () {
            $(this).addClass("is-hidden"), $(".cover-uploader-box, .upload-demo-wrap").toggleClass("is-hidden"), $("#submit-cover-picture").addClass("is-disabled"), $("#upload-cover-picture").val("")
        }))
    }
    if ($("#upload-profile").length) {
        var o = $("#upload-profile").croppie({
            enableExif: !0,
            url: "assets/img/demo/placeholder.png",
            viewport: {width: 130, height: 130, type: "circle"},
            boundary: {width: "100%", height: 300}
        });
        $("#upload-profile-picture").on("change", (function () {
            !function (e) {
                if (e.files && e.files[0]) {
                    var i = new FileReader;
                    i.onload = function (e) {
                        o.croppie("bind", {url: e.target.result}).then((function () {
                            e.target.result, console.log("jQuery bind complete")
                        }))
                    }, i.readAsDataURL(e.files[0])
                } else swal("Sorry - you're browser doesn't support the FileReader API")
            }(this), $(this).closest(".modal").find(".profile-uploader-box, .upload-demo-wrap, .profile-reset").toggleClass("is-hidden"), $("#submit-profile-picture").removeClass("is-disabled")
        })), $("#submit-profile-picture").on("click", (function (e) {
            $(this).addClass("is-loading"), o.croppie("result", {type: "canvas", size: "viewport"}).then((function (e) {
                var i;
                (i = {src: e}).html && i.html, i.src && (i.src, $(".cover-bg .avatar .avatar-image, #user-avatar-minimal").attr("src", i.src), $("#submit-profile-picture").removeClass("is-loading"), $("#upload-crop-profile-modal").removeClass("is-active"))
            }))
        })), $("#profile-upload-reset").on("click", (function () {
            $(this).addClass("is-hidden"), $(".profile-uploader-box, .upload-demo-wrap").toggleClass("is-hidden"), $("#submit-profile-picture").addClass("is-disabled"), $("#upload-profile-picture").val("")
        }))
    }
    $(".close-nested-photos").on("click", (function () {
        $(".album-image-grid").addClass("is-hidden"), $(".albums-grid").removeClass("is-hidden")
    })), $(".user-photos-modal .grid-image input").on("change", (function () {
        $(this).closest(".modal").find(".replace-button").removeClass("is-disabled")
    })), $("#profile-main, #pages-main").length && (initPostComments(), $(".star-friend").on("click", (function () {
        $(this).toggleClass("is-active")
    }))), $("#profile-about").length && ($(".left-menu .menu-item").on("click", (function () {
        var e = $(this).attr("data-content");
        $(".left-menu .menu-item").removeClass("is-active"), $(this).addClass("is-active"), $(".content-section").removeClass("is-active"), $("#" + e).addClass("is-active"), "education-content" != e && "job-content" != e || initAboutGlider()
    })), $(".small-like .inner").on("click", (function () {
        $(this).closest(".small-like").toggleClass("is-active")
    })), $(".video-list .video-wrapper .video-button").modalVideo()), $("#profile-photos, #pages-photos").length && ($(".photo-like").on("click", (function () {
        $(this).hasClass("is-liked") ? $(this).find("svg").removeClass("gelatine") : $(this).find("svg").addClass("gelatine"), $(this).toggleClass("is-liked")
    })), $(".image-grid .image-row > div .overlay").on("click", (function () {
        var e = $(this), i = e.closest(".image-row > div").attr("data-background"),
            o = e.siblings(".image-owner").find("img").attr("src"), s = e.siblings(".image-owner").find(".name").text(),
            t = e.siblings(".photo-time").text();
        $("#lightbox-image").attr("src", i), $("#lightbox-avatar").attr("src", o), $("#lightbox-username").html(s), $("#lightbox-time").html(t), $(".custom-profile-lightbox").addClass("is-active"), setTimeout((function () {
            $(".custom-profile-lightbox").find(".image-loader, .comments-loader").removeClass("is-active")
        }), 1e3)
    })), $(".custom-profile-lightbox .close-lightbox").on("click", (function () {
        $(".custom-profile-lightbox").removeClass("is-active"), setTimeout((function () {
            $(".custom-profile-lightbox").find(".image-loader, .comments-loader").addClass("is-active")
        }), 500)
    })))
}));