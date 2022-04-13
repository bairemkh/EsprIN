const externNameF = document.getElementById('companyNameF');
const externEmailF = document.getElementById('companyEmailF');
const externLocationF = document.getElementById('companyLocationF');
const externPasswordF = document.getElementById('companyPasswordF');
const externIdF = document.getElementById('comIdF');
const submitExtern = document.getElementById('submitExtern');

function verifyExtern(){
    let externName=externNameF.value;
    let externEmail=externEmailF.value;
    let externLocation=externLocationF.value;
    let externPassword=externPasswordF.value;
    let externId=externIdF.value;
    if(externName==="")
        setErrorFor(externNameF,"Name cannot be null");
    if(externId==="")
        setErrorFor(externIdF,"ID cannot be null");
    if(externEmail==="")
        setErrorFor(externEmailF,"Email cannot be null");
    if(externLocation==="")
        setErrorFor(externLocationF,"Location cannot be null");
    if(externPassword=== "")
        setErrorFor(externPasswordF,"Password cannot be null");
    if((externName!=="")&&(externEmail!=="")&&(externLocation!=="")&&(externPassword!=="")&&(externId!=="")&&(externId!=="")){
        removeErrorFor(externNameF);
        removeErrorFor(externEmailF);
        removeErrorFor(externLocationF);
        removeErrorFor(externPasswordF);
        removeErrorFor(externIdF);
        console.log("before submit")
        submitExtern.submit();
    }
}
submitExtern.addEventListener("click",()=>{
    console.log("Entered event")
    verifyExtern();
})
function setErrorFor(errorInput, msg) {
    let formControl = errorInput.parentElement;
    let small = formControl.querySelector('.msg small');
    let msgBox = formControl.querySelector('.msg');
    small.innerText = msg;
    msgBox.className = "msg show";
}

function removeErrorFor(errorInput) {
    let formControl = errorInput.parentElement;
    let msgBox = formControl.querySelector('.msg');
    msgBox.className = "msg";
}