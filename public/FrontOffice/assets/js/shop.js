"use strict";

function initSpinner(t) {
    $(".spinner .add").off().on("click", (function () {
        var t = $(this).closest(".spinner").find("input"), e = parseInt(t.val());
        e = ++e, t.val(e).trigger("change")
    })), $(".spinner .remove").off().on("click", (function () {
        var t = $(this).closest(".spinner").find("input"), e = parseInt(t.val());
        (e = --e) < 1 && (e = 1), t.val(e).trigger("change")
    })), $(".spinner input").off().on("change", (function () {
        var e = $(this), i = parseInt(e.val());
        console.log(i), e.closest(".spinner").find(".value").html(i);
        var s = t * i;
        $("#quickview-button-price").html(s.toFixed(2))
    }))
}

$(document).ready((function () {
    if ($("#shop-page").length && ($(".store-tabs .tab-control").on("click", (function () {
        var t = $(this).attr("data-tab");
        $(this).closest(".store-tabs").find(".tab-control").removeClass("is-active"), $(this).addClass("is-active"), $(".store-tab-pane").removeClass("is-active"), $("#" + t).addClass("is-active")
    })), $(".quickview-trigger").on("click", (function () {
        var t = $(this), e = t.closest(".product-card").attr("data-path"),
            i = t.closest(".product-card").attr("data-name"),
            s = parseInt(t.closest(".product-card").attr("data-price")),
            a = t.closest(".product-card").find("img").attr("src"), o = t.closest(".product-card").attr("data-colors");
        t.closest(".product-card").attr("data-colors");
        $("#quickview-name").html(i), $(".product-quickview .product-image img").attr("src", a), $("#quickview-price, #quickview-button-price").html(s.toFixed(2)), setTimeout((function () {
            $(".quickview-loader").removeClass("is-active")
        }), 1e3), initSpinner(s), "true" === o && ($("#color-properties").removeClass("is-hidden"), $("#color-properties input").off().on("change", (function () {
            var t = $(this).attr("id");
            $(".product-quickview .product-image img").attr("src", e + "-" + t + ".svg")
        }))), $("#product-quickview").addClass("is-active")
    })), $(".quickview-background").on("click", (function () {
        $("#product-quickview").removeClass("is-active"), $(".quickview-loader").addClass("is-active"), $("#color-properties").addClass("is-hidden"), $(".spinner input").val("1"), $(".spinner .value").html("1")
    }))), $(".products-navigation").length && ($(window).on("scroll", (function () {
        $(window).scrollTop() > 65 ? $(".products-navigation").addClass("is-active") : ($(".products-navigation").removeClass("is-active"), $(".navigation-panel").fadeOut(), $(".products-navigation .shop-action").removeClass("is-active"))
    })), $(".products-navigation .shop-action").on("click", (function () {
        var t = $(this).attr("data-panel");
        $(this).hasClass("is-active") ? $(this).removeClass("is-active") : $(this).addClass("is-active"), $("#" + t).slideToggle()
    })), initComboBox()), $("#checkout-button").length && ($("#checkout-button").on("click", (function () {
        var t = $(this), e = $("#checkout-step-title"), i = $("#checkout-back"), s = parseInt(t.attr("data-step")),
            a = parseInt($("#checkout-back").attr("data-step"));
        t.addClass("is-loading"), setTimeout((function () {
            if (t.removeClass("is-loading"), $(".checkout-section").removeClass("is-active"), $("#checkout-section-" + s).addClass("is-active"), t.attr("data-step", s + 1), i.attr("data-step", a + 1), 2 === s) e.html("2. Choose a shipping address"), 0 === $(".shipping-address input:checked").length ? t.addClass("is-disabled") : t.removeClass("is-disabled"); else if (3 === s) e.html("3. Choose a shipping method"), 0 === $(".shipping-box input:checked").length ? t.addClass("is-disabled") : t.removeClass("is-disabled"); else if (4 === s) $(".shipping-logo").addClass("is-active"), e.html("4. Choose a billing address"), 0 === $(".billing-address input:checked").length ? t.addClass("is-disabled") : t.removeClass("is-disabled"); else if (5 === s) {
                var o = window.location.href;
                o.indexOf("navbar-v1") ? window.location.href = "/navbar-v1-ecommerce-payment.html" : o.indexOf("navbar-v2") ? window.location.href = "/navbar-v2-ecommerce-payment.html" : o.indexOf("sidebar-v1") && (window.location.href = "/sidebar-v1-ecommerce-payment.html")
            }
        }), 800)
    })), $("#checkout-back").on("click", (function () {
        var t = $(this), e = $("#checkout-step-title"),
            i = ($("#checkout-back"), parseInt($("#checkout-back").attr("data-step")));
        t.addClass("is-loading"), setTimeout((function () {
            t.removeClass("is-loading"), $(".checkout-section").removeClass("is-active"), $("#checkout-section-" + i).addClass("is-active"), $("#checkout-button").removeClass("is-disabled").attr("data-step", i + 1), t.attr("data-step", i - 1), 0 === i ? window.location.href = "/ecommerce-cart.html" : 1 === i ? e.html("1. Confirm your order") : 2 === i ? (e.html("2. Choose a shipping address"), $(".shipping-logo").removeClass("is-active")) : 3 === i && (e.html("3. Choose a shipping method"), $(".shipping-logo").addClass("is-active"))
        }), 800)
    })), $(".address-box input").on("change", (function () {
        $("#checkout-button").removeClass("is-disabled");
        var t = $(this).closest(".address-box").find(".address-box-inner").html();
        $("#shipping-address-box p").remove(), $("#shipping-address-box").append(t), $("#shipping-placeholder-box").addClass("is-hidden"), $("#shipping-address-box").removeClass("is-hidden")
    })), $(".shipping-box input").on("change", (function () {
        var t = $(this).closest(".shipping-box").find("img").attr("src");
        $(".shipping-logo").attr("src", t).addClass("is-active"), $("#shipping-amount").find(".is-text").removeClass("is-text").html("15.00"), $("#total-amount span:nth-child(2)").html("216.92"), $("#checkout-button").removeClass("is-disabled")
    }))), $("#payment-container").length) {
        var t, e = Stripe("pk_test_6pRNASCoBOKtIshFeQd4XMUh"), i = e.elements(),
            s = window.localStorage.getItem("theme");
        t = null != s && null != s && "dark" != s ? {
            base: {
                fontSize: "14px",
                color: "#595d6e"
            }
        } : {base: {iconColor: "#fff", fontSize: "14px", color: "#fff", "::placeholder": {color: "#6f809e"}}};
        var a = i.create("card", {style: t});
        a.mount("#card-element"), a.addEventListener("change", (function (t) {
            var e = document.getElementById("card-errors");
            t.error ? e.textContent = t.error.message : e.textContent = ""
        })), document.getElementById("stripe-payment-form").addEventListener("submit", (function (t) {
            t.preventDefault(), e.createToken(a).then((function (t) {
                t.error ? document.getElementById("card-errors").textContent = t.error.message : stripeTokenHandler(t.token)
            }))
        })), $(".is-button .buttons").on("click", (function () {
            $(this);
            $("#payment-button").addClass("is-loading"), setTimeout((function () {
                $("#payment-button").removeClass("is-loading"), $("#payment-container, #confirmation-container, .header-actions .button").toggleClass("is-hidden")
            }), 2e3)
        }))
    }
}));