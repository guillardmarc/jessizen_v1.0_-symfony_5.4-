// button navbar:
let bugerBtn = document.querySelector(".navbar-toggler");
bugerBtn.onclick = bugerImg;

function bugerImg()
{
  let statutaria = bugerBtn.getAttribute('aria-expanded')
  let buger_open = document.querySelector(".btn-opened");
  let buger_close = document.querySelector(".btn-closed");

  if (statutaria == "true") {
    buger_open.classList.add("d-none");
    buger_close.classList.remove("d-none");
  }
  else {
    buger_open.classList.remove("d-none");
    buger_close.classList.add("d-none");
  } 
}