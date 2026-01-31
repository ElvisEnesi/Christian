// script file
let open = document.querySelector('#open');
let close = document.querySelector('#close');
let aside = document.querySelector('#aside');
// sidebar function
function openSide() {
    open.style.display = "none";
    close.style.display = "flex";
    aside.style.left = "0px";
}
open.addEventListener("click", openSide);
function closeSide() {
    close.style.display = "none";
    open.style.display = "flex";
    aside.style.left = "-450px";
}
close.addEventListener("click", closeSide);