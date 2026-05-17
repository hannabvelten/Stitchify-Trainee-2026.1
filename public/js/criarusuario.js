const abrirCriar = document.querySelector(".criar-usuario");
const fecharCriar = document.querySelector(".x");
const modalCriar = document.querySelector(".modal-criaruser");
const fadeCriar = document.querySelector(".fade-criaruser");

const toggleCriar = () => {
    modalCriar.classList.toggle("hide");
};

[abrirCriar, fecharCriar, fadeCriar].forEach((el) => {
    el.addEventListener("click", toggleCriar);
});