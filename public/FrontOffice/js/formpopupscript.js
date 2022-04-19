const open = document.getElementById("open");
const modelContainer = document.getElementById("model-container");
const close = document.getElementById("close");


const filed1 = document.getElementById('field1');
const filed2 = document.getElementById('field2');
const filed3 = document.getElementById('field3');
const submit= document.getElementById('submit');

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

submit.addEventListener("click",()=>{
    console.log("Entered event")
    verifyExtern();
    console.log("exited event")
})

open.addEventListener("click", () => {
    modelContainer.classList.add('show');
});
close.addEventListener("click", () => {
    modelContainer.classList.remove('show');
});


function setErrorFor(errorInput, msg) {
    let formControl = errorInput.parentElement;
    let small = formControl.querySelector('small.errorMsg')
    let msgBox = formControl.querySelector('.msg');
    small.innerText = msg;
    msgBox.className = "errorMsg show";
}

function removeErrorFor(errorInput) {
    let formControl = errorInput.parentElement;
    let msgBox = formControl.querySelector('.msg');
    msgBox.className = "msg";
}