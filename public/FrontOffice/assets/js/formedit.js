const editmodelContainer = document.getElementById("container-edit");
const edit = document.getElementById("openedit")
const closeedit = document.getElementById("closeedit");


/*const filed1 = document.getElementById('title');
const filed2 = document.getElementById('content');
const filed3 = document.getElementById('tag');
const submit= document.getElementById('editforum');*/

//const editForm = document.getElementById('editForum');


edit.addEventListener("click", () => {
    editmodelContainer.classList.add('show');
});

closeedit.addEventListener("click", () => {
    console.log("teeeeeeeeeeeeeeeeeeeeeeeee")
    editmodelContainer.classList.remove('show');
});