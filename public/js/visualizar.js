const abrirVisualizar = document.querySelectorAll(".btn-visualizar");
const fecharVisualizar = document.querySelector(".fechar");
const modalVisualizar = document.querySelector(".modal-visualizar");
const fadeVisualizar = document.querySelector(".fadev");

    const toggleVisualizar = () => {
    modalVisualizar.classList.toggle("hide");
    fadeVisualizar.classList.toggle("hide");
};


abrirVisualizar.forEach((botao) => {
    botao.addEventListener("click", toggleVisualizar);
});

[fecharVisualizar, fadeVisualizar].forEach((el) => {
    el.addEventListener("click", toggleVisualizar);
});