/*! modal-uploader.js | Friendkit | © Css Ninja. 2019-2020 */
"use strict";
if ($(".modal-uploader").length) {
    var uploadCount = 0;
    Dropzone.autoDiscover = !1;
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);
    var modalUploader = new Dropzone(document.body, {
        url: "https://www.cssninja.io/dropzone.php",
        thumbnailWidth: 800,
        thumbnailHeight: 600,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoProcessQueue: !0,
        autoQueue: !0,
        previewsContainer: "#previews",
        clickable: ".fileinput-button"
    });
    modalUploader.on("addedfile", (function (e) {
        var o = modalUploader.files.length;
        uploadCount += 1, e.previewElement.querySelector(".start").onclick = function () {
            modalUploader.enqueueFile(e)
        }, e.previewElement.id = "uploaded-file-" + uploadCount, e.previewElement.querySelector("textarea").setAttribute("name", "uploaded_file_textarea_" + uploadCount), e.previewElement.querySelector("textarea").id = "uploaded-file-textarea-" + uploadCount, $("#modal-uploader-file-count").html(o)
    })), modalUploader.on("removedfile", (function (e) {
        var o = modalUploader.files.length;
        $("#modal-uploader-file-count").html(o)
    })), modalUploader.on("totaluploadprogress", (function (e) {
        document.querySelector("#total-progress .progress-bar").style.width = e + "%"
    })), modalUploader.on("sending", (function (e) {
        document.querySelector("#total-progress").style.opacity = "1", e.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })), modalUploader.on("queuecomplete", (function (e) {
        document.querySelector("#total-progress").style.opacity = "0"
    })), document.querySelector("#actions .start").onclick = function () {
        modalUploader.enqueueFiles(modalUploader.getFilesWithStatus(Dropzone.ADDED))
    }, document.querySelector("#actions .cancel").onclick = function () {
        modalUploader.removeAllFiles(!0)
    };
    var minSteps = 6, maxSteps = 60, timeBetweenSteps = 100, bytesPerStep = 1e5;
    modalUploader.uploadFiles = function (e) {
        for (var o = this, t = 0; t < e.length; t++) for (var l = e[t], r = Math.round(Math.min(maxSteps, Math.max(minSteps, l.size / bytesPerStep))), a = 0; a < r; a++) {
            var n = timeBetweenSteps * (a + 1);
            setTimeout(function (e, t, l) {
                return function () {
                    e.upload = {
                        progress: 100 * (l + 1) / t,
                        total: e.size,
                        bytesSent: (l + 1) * e.size / t
                    }, o.emit("uploadprogress", e, e.upload.progress, e.upload.bytesSent), 100 == e.upload.progress && (e.status = Dropzone.SUCCESS, o.emit("success", e, "success", null), o.emit("complete", e), o.processQueue())
                }
            }(l, r, a), n)
        }
    }
}