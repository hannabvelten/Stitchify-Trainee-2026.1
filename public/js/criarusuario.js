const abrirCriar = document.querySelector(".criar-usuario");
const fecharCriar = document.querySelector(".x");
const modalCriar = document.querySelector(".modal-criaruser");
const fadeCriar = document.querySelector(".fade-criaruser");
const botaoFoto = document.querySelector(".foto-usuario");
const inputFoto = document.querySelector("#foto-usuario");

botaoFoto.addEventListener("click", () => {
    inputFoto.click();
});

inputFoto.addEventListener("change", () => {
    const arquivo = inputFoto.files[0];
    if (arquivo) {
        console.log("Foto selecionada:", arquivo.name);
    }

}); 


const toggleCriar = () => {
    modalCriar.classList.toggle("hide");
};

[abrirCriar, fecharCriar, fadeCriar].forEach((el) => {
    el.addEventListener("click", toggleCriar);
});