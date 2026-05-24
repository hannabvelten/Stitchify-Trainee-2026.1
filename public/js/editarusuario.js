const openEditButton = document.querySelectorAll(".editar");
const closeEditButton = document.querySelector(".modal-editar .cancel");
const modalEdit = document.querySelector("#modal-editar");
const fadeEdit = document.querySelector("#fade-edit");

const toggleModalEdit = () => {
    [modalEdit, fadeEdit].forEach((el) => el.classList.toggle("hide"));
};

openEditButton.forEach((btn) => {
    btn.addEventListener("click", () => toggleModalEdit());
});

[closeEditButton, fadeEdit].forEach((el) => {
    el.addEventListener("click", () => toggleModalEdit());
});