const open = document.getElementById("open");
const modelContainer = document.getElementById("model-container");
const close = document.getElementById("close");
//const feedContainer = document.getElementById("eventContainer");


open.addEventListener("click", () => {
    console.log('test')
    modelContainer.classList.add('show');
    //feedContainer.style.position="fixed";
});
close.addEventListener("click", () => {
    modelContainer.classList.remove('show');
    //feedContainer.style.position="relative";
});
/*
modelContainer.addEventListener("click", ()  => {
    console.log('test')
    modelContainer.classList.remove('show');
    //feedContainer.style.position="relative";
});*/