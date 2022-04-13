const subjectField = document.getElementById('subjectF');
const contentField = document.getElementById('contentF');
const destinationField = document.getElementById('destinationF');
const categoryField = document.getElementById('CategoryF');
const submit = document.getElementById('submitBtn');
let validate=false;



function verifyAddAnnounce(){
    let subject=subjectField.value;
    let content=contentField.value;
    let destination=destinationField.value;
    let category=categoryField.value;
    if(subject==="")
        setErrorFor(subjectField,"Subject cannot be null");
    if(content==="")
        setErrorFor(contentField,"Content cannot be null");
    if(destination==="")
        setErrorFor(destinationField,"Destination cannot be null");
    if(category.selectedIndex === 0)
        setErrorFor(categoryField,"Category cannot be null");
    if((subject!="")&&(content!="")&&(destination!="")&&(category.selectedIndex != 0)){
        removeErrorFor(subjectField);
        removeErrorFor(contentField);
        removeErrorFor(destinationField);
        removeErrorFor(categoryField);
        submit.submit();
    }
}
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

submit.addEventListener("click",()=>{
    verifyAddAnnounce();
})

