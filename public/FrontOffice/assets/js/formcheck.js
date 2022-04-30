const open = document.getElementById("open");
const modelContainer = document.getElementById("model-container");
const close = document.getElementById("close");



const filed1 = document.getElementById('field1');
const filed2 = document.getElementById('field2');
const filed3 = document.getElementById('field3');
const submit= document.getElementById('submit');

const myForm = document.getElementById('addForum');



open.addEventListener("click", () => {
    modelContainer.classList.add('show');
});


myForm.addEventListener("submit",(e)=>{
    let field1= filed1.value;
    let field2=filed2.value;
    let field3=filed3.value;
    let myError = document.getElementById("errorMsg");
    if(field1==="") {
        console.log("test###########")
        myError.innerHTML = "Ce champs est requis";
        myError.style.color = 'white';
        e.preventDefault();
    }
    if(field2===""){
        console.log("test###########")
        myError.innerHTML = "Ce champs est requis";
        myError.style.color = 'white';
        e.preventDefault();
    }
    if(field3===""){
        console.log("test###########")
        myError.innerHTML = "Ce champs est requis";
        myError.style.color = 'white';
        e.preventDefault();
    }

    if((field1!=="")&&(field2!=="")&&(field3!=="")){
        submit.submit();
    }
})
close.addEventListener("click", () => {
    modelContainer.classList.remove('show');
});




