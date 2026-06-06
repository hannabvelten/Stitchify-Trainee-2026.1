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
    btn.addEventListener("click", () => {
        const idUsuario = btn.getAttribute('data-id');
        const nomeUsuario = btn.getAttribute('data-nome');
        const emailUsuario = btn.getAttribute('data-email');
        const inputIdEditar = document.querySelector("#id_usuario_editar");
        if(inputIdEditar) {
            inputIdEditar.value = idUsuario;
        }
        const inputNome = document.querySelector(".modaledit input[name='nome']");
        const inputEmail = document.querySelector(".modaledit input[name='email']");
        
        if (inputNome) inputNome.value = nomeUsuario;
        if (inputEmail) inputEmail.value = emailUsuario;

        toggleModalEdit();
    });
});

// openEditButton.forEach((btn) => {
//     btn.addEventListener("click", () => {
//         const idUsuario = btn.getAttribute('data-id');
//         const inputIdEditar = document.querySelector("#id_usuario_editar");
//         if(inputIdEditar) {
//             inputIdEditar.value = idUsuario;
//         }
        
//         toggleModalEdit();
//     });
// });

// openEditButton.forEach((btn) => {
//     btn.addEventListener("click", () => toggleModalEdit());
// });

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