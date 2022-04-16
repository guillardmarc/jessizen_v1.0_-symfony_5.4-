// Button Back to top:
window.addEventListener('scroll', () => { 
    const nav = document.querySelector(".back-to-top");
    if(window.scrollY > 100 ){
        nav.classList.remove("d-none");
    }
    else{
        nav.classList.add("d-none");
    }
  })