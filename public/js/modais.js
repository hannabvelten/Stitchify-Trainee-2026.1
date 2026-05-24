const filtro = document.getElementById('filtro');

function abriModal(idModal){
    const modal = document.getElementById(idModal);
    modal.style.display = "flex";
    filtro.style.display = "flex";
    document.body.style.overflow = "hidden";
}

function fecharModal(idModal){
    const modal = document.getElementById(idModal);
    modal.style.display = "none";
    filtro.style.display = "none";
    document.body.style.overflow = "";
}