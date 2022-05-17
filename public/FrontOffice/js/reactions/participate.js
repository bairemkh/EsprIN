
function onClickBtnParticipate(event) {
        event.preventDefault();
        const url=this.href;
    const count=this.parentElement.parentElement.querySelector('.count');
        axios.get(url).then(function (response) {
          console.log(response.data.nbrParticipation);
          const likes =response.data.nbrParticipation;
           count.textContent=likes;
            console.log(count);
        })
}

document.querySelectorAll('a.like-button').forEach(function (link) {
    link.addEventListener('click',onClickBtnParticipate);
})