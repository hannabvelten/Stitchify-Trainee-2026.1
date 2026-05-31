const abrirCriar = document.querySelector(".criar-usuario");
const fecharCriar = document.querySelector(".cancelar-modal");
const modalCriar = document.querySelector(".modal-criaruser");
const fadeCriar = document.querySelector(".fade-criaruser");
const botaoFoto = document.querySelector(".foto-usuario");
const inputFoto = document.querySelector("#foto-usuario");

const criarUsuariosBtn = document.querySelector("criar-modal");
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
criarUsuariosBtn.addEventListener("click", () =>{
    const nome= document.querySelector(' .inputs-modal input[placeholder="Nome Completo"]').value;
    const email= document.querySelector('.inputs-modal input[placeholder="Email"]').value;
    const senha = document.querySelector(' .inputs-modal input[placeholder="Senha"]').value;
    const foto = inputFoto.files[0];
    if(!nome || !email || !senha){
        console.log("Por favor, preencha todos os campos");
        return;
    }
});