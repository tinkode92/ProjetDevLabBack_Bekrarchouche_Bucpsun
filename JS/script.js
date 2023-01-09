const targetEl1 = document.querySelector("#user-dropdown");
const targetEl2 = document.querySelector("#mobile-menu-2");
const triggerEl1 = document.querySelector("#user-menu-button");
const triggerEl2 = document.querySelector("#btn-drop");


triggerEl1.addEventListener("click", function () {
    if(targetEl1.style.display === "none") {
        targetEl1.style.display = "block";
    } else {
        targetEl1.style.display = "none";
    }
});

triggerEl2.addEventListener("click", function () {
    if(targetEl2.style.display === "none") {
        targetEl2.style.display = "block";
    } else {
        targetEl2.style.display = "none";
    }
});

let nolike = document.querySelector(".no_like")

if (nolike.children.length <= 0) {
    let message = document.createElement("p")
    message.innerHTML = "Pas d'album liké pour le moment"
    message.classList = "flex justify-center font-semibold text-lg"
    nolike.appendChild(message)
}