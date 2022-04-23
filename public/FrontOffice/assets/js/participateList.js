const open = document.getElementById("List");
const modelContainer = document.getElementById("wrapper");
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