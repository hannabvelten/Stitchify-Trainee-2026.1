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



// Carrossel de posts

const sliderAutor = document.querySelector('.slider-conteudo-autor');
const leftArrowAutor = document.getElementById("seta-esquerda");
const rightArrowAutor = document.getElementById("seta-direita");

if (sliderAutor) {
    let currentPageAutor = 0;
    let autoSlideAutor;

    function totalPagesAutor() {
        const itens = sliderAutor.children.length;
        const perView = window.innerWidth <= 767 ? 1 : window.innerWidth <= 1200 ? 2 : 3;
        return Math.ceil(itens / perView);
    }

    function scrollAutor() {
        sliderAutor.scrollTo({ left: currentPageAutor * sliderAutor.offsetWidth, behavior: 'smooth' });
    }

    function moveLeftAutor() {
        currentPageAutor = currentPageAutor <= 0 ? totalPagesAutor() - 1 : currentPageAutor - 1;
        scrollAutor();
        resetAutoAutor();
    }

    function moveRightAutor() {
        currentPageAutor = currentPageAutor >= totalPagesAutor() - 1 ? 0 : currentPageAutor + 1;
        scrollAutor();
        resetAutoAutor();
    }

    function resetAutoAutor() {
        clearInterval(autoSlideAutor);
        autoSlideAutor = setInterval(moveRightAutor, 5000);
    }

    leftArrowAutor.addEventListener('click', moveLeftAutor);
    rightArrowAutor.addEventListener('click', moveRightAutor);
    window.addEventListener('resize', () => { currentPageAutor = 0; scrollAutor(); });

    resetAutoAutor();
}