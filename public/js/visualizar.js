document.querySelectorAll('.btn-visualizar').forEach(botao => {
    botao.addEventListener('click', () => {
        const id = botao.getAttribute('data-id');
        const modalEspecifico = document.getElementById(`modal-visualizar-${id}`);
        const fadeEspecifico = modalEspecifico ? modalEspecifico.previousElementSibling : null;
        if (modalEspecifico) {
            modalEspecifico.classList.remove('hide');
            if (fadeEspecifico && fadeEspecifico.classList.contains('fadev')) {
                fadeEspecifico.classList.remove('hide');
            }
        }
    });
});