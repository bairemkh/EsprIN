"use strict";
/*! landing.js | Friendkit | © Css Ninja. 2019-2020 */
$(document).ready((function () {
    if ($(".landing-wrapper").length) {
        var e = function (e) {
            if (0 == (e = "string" == typeof e ? e : $(this).attr("href")).indexOf("#")) {
                var t = $(e);
                if (t.length && ($("html, body").animate({scrollTop: t.offset().top - 50}), history && "pushState" in history)) return history.pushState({}, document.title, window.location.pathname + e), !1
            }
        };
        e(window.location.hash), $("body").on("click", "a", e), window.sr = ScrollReveal(), sr.reveal(".is-single-reveal", {
            origin: "bottom",
            distance: "20px",
            duration: 600,
            delay: 300,
            rotate: {x: 0, y: 0, z: 0},
            opacity: 0,
            scale: 1,
            easing: "cubic-bezier(0.215, 0.61, 0.355, 1)",
            container: window.document.documentElement,
            mobile: !0,
            reset: !1,
            useDelay: "always",
            viewFactor: .2
        }), sr.reveal(".is-box-reveal", {
            origin: "bottom",
            distance: "20px",
            duration: 600,
            delay: 100,
            rotate: {x: 0, y: 0, z: 0},
            opacity: 0,
            scale: 1,
            easing: "cubic-bezier(0.215, 0.61, 0.355, 1)",
            container: window.document.documentElement,
            mobile: !0,
            reset: !0,
            useDelay: "always",
            viewFactor: .2
        }, 100), $("#particles-js").length && particlesJS("particles-js", {
            particles: {
                number: {
                    value: 50,
                    density: {enable: !0, value_area: 1e3}
                },
                color: {value: ["#5596e6"]},
                shape: {
                    type: "circle",
                    stroke: {width: 5, color: "#5596e6"},
                    fill: {color: "#5596e6"},
                    polygon: {nb_sides: 5},
                    image: {src: "img/github.svg", width: 100, height: 100}
                },
                opacity: {value: .6, random: !1, anim: {enable: !1, speed: 1, opacity_min: .1, sync: !1}},
                size: {value: 4, random: !0, anim: {enable: !1, speed: 40, size_min: .1, sync: !1}},
                line_linked: {enable: !1, distance: 120, color: "#1a72ff", opacity: .2, width: 1.6},
                move: {
                    enable: !0,
                    speed: 3,
                    direction: "top",
                    random: !1,
                    straight: !1,
                    out_mode: "out",
                    bounce: !1,
                    attract: {enable: !1, rotateX: 600, rotateY: 1200}
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {onhover: {enable: !0, mode: "grab"}, onclick: {enable: !1}, resize: !0},
                modes: {
                    grab: {distance: 140, line_linked: {opacity: 1}},
                    bubble: {distance: 400, size: 40, duration: 2, opacity: 8, speed: 3},
                    repulse: {distance: 200, duration: .4},
                    push: {particles_nb: 4},
                    remove: {particles_nb: 2}
                }
            },
            retina_detect: !0
        })
    }
}));