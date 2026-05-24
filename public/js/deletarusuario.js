const openDeleteButton = document.querySelectorAll(".deletar");
const closeDeleteButton = document.querySelector(".modal-deletar .cancel-delete");
const modalDelete = document.querySelector("#modal-deletar");
const fadeDelete = document.querySelector("#fade-delete");

const toggleModalDelete = () => {
    [modalDelete, fadeDelete].forEach((el) => el.classList.toggle("hide"));
};

openDeleteButton.forEach((btn) => {
    btn.addEventListener("click", () => toggleModalDelete());
});

[closeDeleteButton, fadeDelete].forEach((el) => {
    el.addEventListener("click", () => toggleModalDelete());
});