/*! go-live.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";
var video, webcamStream, audioStream;
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
var startButton = document.getElementById("start-stream"), stopButton = document.getElementById("stop-stream"),
    liveIndicator = document.getElementById("live-indicator");

function startWebcam() {
    navigator.getUserMedia ? (navigator.getUserMedia({video: !0, audio: !1}, (function (t) {
        video = document.querySelector("video");
        try {
            video.srcObject = t
        } catch (e) {
            video.src = window.URL.createObjectURL(t)
        }
        webcamStream = t.getTracks()[0], audioStream = t.getTracks()[1]
    }), (function (t) {
        console.log("The following error occured: " + t)
    })), startButton.classList.toggle("is-hidden"), stopButton.classList.toggle("is-hidden"), liveIndicator.classList.toggle("is-vhidden")) : console.log("getUserMedia not supported")
}

function stopWebcam() {
    webcamStream.stop(), stopButton.classList.toggle("is-hidden"), startButton.classList.toggle("is-hidden"), liveIndicator.classList.toggle("is-vhidden")
}