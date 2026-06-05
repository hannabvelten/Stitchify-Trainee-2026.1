const openEditButton = document.querySelectorAll(".editar");
const closeEditButton = document.querySelector(".modal-editar .cancel");
const modalEdit = document.querySelector("#modal-editar");
const fadeEdit = document.querySelector("#fade-edit");
const btnFotoEdit = document.querySelector("#btnFotoEdit");
const inputFotoEdit = document.querySelector("#inputFotoEdit");
const fotoIconEdit = document.querySelector("#fotoIconEdit");
const fotoPreviewEdit = document.querySelector("#fotoPreviewEdit");

const toggleModalEdit = () => {
    [modalEdit, fadeEdit].forEach((el) => el.classList.toggle("hide"));
};

openEditButton.forEach((btn) => {
    btn.addEventListener("click", () => toggleModalEdit());
});

[closeEditButton, fadeEdit].forEach((el) => {
    el.addEventListener("click", () => toggleModalEdit());
});

btnFotoEdit.addEventListener("click", () => {
    inputFotoEdit.click();
});

inputFotoEdit.addEventListener("change", () => {
    const arquivo = inputFotoEdit.files[0];
    if (arquivo) {
        const url = URL.createObjectURL(arquivo);
        fotoIconEdit.style.display = "none";
        fotoPreviewEdit.style.display = "block";
        fotoPreviewEdit.src = url;
    }
});