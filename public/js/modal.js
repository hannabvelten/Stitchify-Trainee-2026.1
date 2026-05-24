const fundoModal = document.getElementById('fundoModal');

function abrirModal(idModal){

    const modal = document.getElementById(idModal);

    modal.style.display = "flex";

    fundoModal.style.display = "block";

    document.body.style.overflow = "hidden";
}

function fecharModal(idModal){

    const modal = document.getElementById(idModal);

    modal.style.display = "none";

    fundoModal.style.display = "none";

    document.body.style.overflow = "auto";
}