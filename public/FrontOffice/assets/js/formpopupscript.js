const open = document.getElementById("open");
const modelContainer = document.getElementById("model-container");
const close = document.getElementById("close");

open.addEventListener("click", () => {
    modelContainer.classList.add('show');
});
close.addEventListener("click", () => {
    modelContainer.classList.remove('show');
});