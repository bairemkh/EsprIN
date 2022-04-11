const btnNext = document.querySelector('form .btn .next');
const btnprev = document.querySelector('form .btn .prev');
const indicator = document.querySelector('.indicator .line span');
const indicatorItems = document.querySelectorAll('.indicator p');
const form = document.querySelector('form');
const allTab = document.querySelectorAll('form .tab');
const roleSelector = document.getElementById("roleSelector");
const roleForms = document.querySelectorAll('form .typeUser');
const regForm = document.getElementById("registrationForm");
const firstNameField = document.getElementById("firstName");
const lastNameField = document.getElementById("lastName");
const emailField = document.getElementById("email");
const specStudent = document.getElementById("specStudent");
const gradeStudent = document.getElementById("grade");
const studentStudySpec = document.getElementById("studentStudySpec");
const classNum = document.getElementById("classNum");
const specProf = document.getElementById("specProf");
const typeClub = document.getElementById("typeClub");
const cin = document.getElementById("cin");
const passwd = document.getElementById("password");
const passwd2 = document.getElementById("password2");

let verifName = false;
let verifLastName = false;
let verifGrade = false;
let verifStudentSpec = false;
let verifStudentclass = false;
let verifCIN = false;
let verifPasswd=false;
let next = false;

regForm.action = 'user/createStudentAccount';


let i = 0;
allTab[i].classList.add('show');
indicator.style.width = i;
if (i === 0) {
    btnprev.style.display = 'none';
} else {
    btnprev.style.display = 'block';
}

if (i === allTab.length - 1) {
    btnNext.innerHTML = 'Submit';
} else {
    btnNext.innerHTML = 'Next';
}


roleSelector.addEventListener('change', function () {
    console.log(`You selected: ${this.value}`);
    if (this.value === "Student") {
        roleForms[2].classList.remove('show');
        roleForms[1].classList.remove('show');
        roleForms[0].classList.add('show');
        //specStudent.selectedIndex===0
        regForm.action = 'user/createStudentAccount';

    } else if (this.value === "Professor") {
        roleForms[0].classList.remove('show');
        roleForms[2].classList.remove('show');
        roleForms[1].classList.add('show');
        regForm.action = 'Professor';
    } else if (this.value === "Club") {
        roleForms[0].classList.remove('show');
        roleForms[1].classList.remove('show');
        roleForms[2].classList.add('show');
        regForm.action = 'club';
    } else {
        roleForms[0].classList.remove('show');
        roleForms[1].classList.remove('show');
        roleForms[2].classList.remove('show');
        next = false;
    }
    verifyRole(roleSelector.selectedIndex);
})

function verifyRole(role) {
    switch (role) {
        case 1:
            if (specStudent.selectedIndex === 0) {
                setErrorFor(specStudent, "Select a specialty")
                next = false;
            } else {
                if ((gradeStudent.value === "") || (specStudent.value === "") || (classNum.value === "")) {
                    next = false;
                } else {
                    next = true;
                }
            }
            break;
        case 2:
            if (specProf.selectedIndex === 0) {
                setErrorFor(specProf, "Select a specialty")
                next = false;
            } else {
                next = true;
            }
            break;
        case 3:
            if (typeClub.selectedIndex === 0) {
                setErrorFor(typeClub, "Select a type")
                next = false;
            } else {
                next = true;
            }
            break;
        default:
            setErrorFor(roleSelector, "Select a role")
            next = false;
            break;
    }
}

//next btn
btnNext.addEventListener('click', function () {
    page1Verif();
    pageRoleVerif();
    if ((i < allTab.length - 1) && (next)) {
        i += 1;
        console.log(next);
        for (let j = 0; j < allTab.length; j++) {
            allTab[j].classList.remove('show');
            //indicatorItems[j].classList.remove('active');
        }
        for (let j = 0; j < i; j++) {
            indicatorItems[j].classList.add('active');
        }
        allTab[i].classList.add('show');
        if (i < allTab.length) {
            indicator.style.width = `${i * 30}%`;
        }
        indicatorItems[i].classList.add('active');
        if (i === 0) {
            btnprev.style.display = 'none';
        } else {
            btnprev.style.display = 'block';
        }
        if (i === allTab.length - 1) {
            btnNext.innerHTML = 'Submit';
        } else {
            btnNext.innerHTML = 'Next';
        }
        next = false;
        console.log(next);
    } else {
        identityVerif();
        if(next) {
            form.submit();
        }

    }

})
btnprev.addEventListener('click', function () {
    i -= 1;
    next = true;
    for (let j = 0; j < allTab.length; j++) {
        allTab[j].classList.remove('show');
        //indicatorItems[j].classList.remove('active');
    }

    allTab[i].classList.add('show');
    indicator.style.width = `${i * 30}%`;
    indicatorItems[i + 1].classList.remove('active');
    if (i === 0) {
        btnprev.style.display = 'none';
    } else {
        btnprev.style.display = 'block';
    }
    if (i === allTab.length - 1) {
        btnNext.innerHTML = 'Submit';
    } else {
        btnNext.innerHTML = 'Next';
    }
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

/*#region name verif real-time*/
firstNameField.addEventListener("input", (e) => {
    const pattern = /^[a-zA-Z]+$/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        next = true;
    } else {
        setErrorFor(e.target, "First name don't have numbers");
        next = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "First name field is empty");
        next = false;
    }
    console.log(pattern.test(currentValue));

    verifName = pattern.test(currentValue);
})
/*#endregion*/
/*#region lastname verif real-time*/
lastNameField.addEventListener("input", (e) => {
    const pattern = /^[a-zA-Z]*$/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        next = true;
    } else {
        setErrorFor(e.target, "Last name don't have numbers");
        next = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "Last name field is empty");
        next = false;
    }
    console.log(pattern.test(currentValue));
    verifLastName = pattern.test(currentValue);
})
/*#endregion*/
/*#region email verif real-time*/
emailField.addEventListener("input", (e) => {
    const pattern = /[a-z A-Z]+[.][a-z A-Z]+(@esprit.tn)/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        next = true;
    } else {
        setErrorFor(e.target, "Email structure is invalid . type your esprit email");
        next = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "Email cannot be empty");
        next = false;
    }
    console.log(pattern.test(currentValue));
    next = pattern.test(currentValue);
})

/*#endregion*/

function page1Verif() {
    if (i === 0)
        next = verifLastName && verifName;
}

specProf.addEventListener("change", (e) => {
    if (e.target.selectedIndex === 0) {
        next = false;
    } else {
        next = true;
    }
})
typeClub.addEventListener("change", (e) => {
    if (e.target.selectedIndex === 0) {
        console.log(e.target.selectedIndex)
        setErrorFor(e.target, "Please select a type")
        next = false;
    } else {
        console.log(e.target.value)
        removeErrorFor(e.target);
        next = true;
    }
})
specStudent.addEventListener("change", (e) => {
    if (e.target.selectedIndex === 0) {
        console.log(e.target.selectedIndex)
        setErrorFor(e.target, "Please select specialty")
        next = false;
    } else {
        removeErrorFor(e.target);
        console.log(e.target.value)

        next = true;
    }
})
/*#region student*/
/*#region student spec real-time*/
studentStudySpec.addEventListener("input", (e) => {
    const pattern = /^[a-zA-Z]+$/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifStudentSpec = true;
    } else {
        setErrorFor(e.target, "Speciality is invalid . make sure that you've typed it correctly");
        verifStudentSpec = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "Speciality cannot be empty");
        verifStudentSpec = false;
    }
    console.log(pattern.test(currentValue));
    verifStudentSpec = pattern.test(currentValue);
})

/*#endregion*/
/*#region grade real-time*/
gradeStudent.addEventListener("input", (e) => {
    const pattern = /[1-5]/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifGrade = true;
    } else {
        setErrorFor(e.target, "Grade is invalid . your grade should be between 1 and 5");
        verifGrade = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "grade cannot be empty");
        verifGrade = false;
    }
    console.log(pattern.test(currentValue));
    verifGrade = pattern.test(currentValue);
})

/*#endregion*/
/*#region class num real-time*/
classNum.addEventListener("input", (e) => {
    const pattern = /^\d{1,2}$/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifStudentclass = true;
    } else {
        setErrorFor(e.target, "class number is invalid . make sure that you've typed it correctly");
        verifStudentclass = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "class number cannot be empty");
        verifStudentclass = false;
    }
    console.log(pattern.test(currentValue));
    verifStudentclass = pattern.test(currentValue);
})

/*#endregion*/

/*#endregion*/
function pageRoleVerif() {
    if ((i === 2) && (roleSelector.value === "Student"))
        next = (verifStudentclass && verifGrade) && verifStudentSpec && (specStudent.selectedIndex != 0);
}
/*#region Identifier*/
/*#region CIN real-time*/
cin.addEventListener("input", (e) => {
    const pattern = /\d{8}/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifCIN = true;
    } else {
        setErrorFor(e.target, "CIN is invalid");
        verifCIN = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "CIN cannot be empty");
        verifCIN = false;
    }
    console.log(pattern.test(currentValue));
    verifCIN = pattern.test(currentValue);
})

/*#endregion*/
/*#region grade real-time*/
passwd.addEventListener("input", (e) => {
    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifPasswd = true;
    } else {
        setErrorFor(e.target, "Password must contains at least  1 uppercase,1 lowercase and digits");
        verifPasswd = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "Password cannot be empty");
        verifPasswd = false;
    }
    console.log(pattern.test(currentValue));
    verifPasswd = pattern.test(currentValue);
})

/*#endregion*/
/*#region class num real-time*/
passwd2.addEventListener("input", (e) => {
    const pattern = new RegExp(passwd.value);
    let currentValue = e.target.value;
    if (pattern.test(currentValue)) {
        removeErrorFor(e.target);
        verifStudentclass = true;
    } else {
        setErrorFor(e.target, "The two passwords are not identical");
        verifStudentclass = false;
    }
    if (e.target.value === "") {
        console.log(pattern.test(currentValue));
        setErrorFor(e.target, "you must confirm your password");
        verifStudentclass = false;
    }
    console.log(pattern.test(currentValue));
    verifPasswd=pattern.test(currentValue);
})

/*#endregion*/

function identityVerif() {
    if (i === 3)
        next = verifPasswd&&verifCIN;
}

/*#endregion*/

