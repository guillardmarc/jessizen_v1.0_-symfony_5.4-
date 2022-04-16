// Img hover
let zoomTopImg = document.querySelector("#zoomTopImg");
let imgZoomTopImg = document.querySelector("#imgZoomTopImg");

// img.onclick = test;
zoomTopImg.onmouseover = imgHoverTop;
zoomTopImg.onmouseout = imgNoHoverTop;


function imgHoverTop() {
    zoomTopImg.classList.add("img-hover");
    zoomTopImg.classList.remove("form-01");
    imgZoomTopImg.classList.remove("img-fluid-vh-40");
    imgZoomTopImg.classList.add("img-fluid");
}

function imgNoHoverTop() {
    zoomTopImg.classList.add("form-01");
    zoomTopImg.classList.remove("img-hover");
    imgZoomTopImg.classList.add("img-fluid-vh-40");
    imgZoomTopImg.classList.remove("img-fluid");
}