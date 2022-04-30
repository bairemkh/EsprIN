const open = document.getElementById("open");

const modelContainer = document.getElementById("model-container");
const close = document.getElementById("close");


const filed1 = document.getElementById('field1');
const filed2 = document.getElementById('field2');
const filed3 = document.getElementById('field3');
const submit= document.getElementById('submit');

const myForm = document.getElementById('addForum');

function verifyExtern(){
    console.log("inside verify extern")
    let field1= filed1.value;
    let field2=filed2.value;
    let field3=filed3.value;

    if(field1==="") {
        setErrorFor(field1, "title cannot be null");
        console.log("extern name")
    }
    if(field2==="")
        setErrorFor(field2,"content cannot be null");
    if((field3===""))
        setErrorFor(field3,"tag cannot be null");

    if((field1!=="")&&(field2!=="")&&(field3!=="")){
        removeErrorFor(field1);
        removeErrorFor(field2);
        removeErrorFor(field3);
        console.log("before submit")
        submit.submit();
    }
}



open.addEventListener("click", () => {
    modelContainer.classList.add('show');
});

myForm.addEventListener("submit",(e)=>{
    if(filed1.value.trim() === ""){
        console.log("test###########")
        let myError = document.getElementById("errorMsg");
        myError.innerHTML = "Ce champs est requis";
        myError.style.color = 'white';
        submit.
        e.preventDefault();
    }
})
close.addEventListener("click", () => {
    modelContainer.classList.remove('show');
});


function setErrorFor(errorInput, msg) {
    let formControl = errorInput.parentElement;
    let small = formControl.querySelector('.errorMsg')
    let msgBox = formControl.querySelector('.msg');
    small.innerText = msg;
    msgBox.className = "errorMsg";
}

function removeErrorFor(errorInput) {
    let formControl = errorInput.parentElement;
    let msgBox = formControl.querySelector('.msg');
    msgBox.className = "msg";
}