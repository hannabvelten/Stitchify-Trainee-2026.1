// Passando elementos HTML para variavies JavaScript
const slider = document.querySelector('.cards-blog');
const sliderContent = document.querySelector('.slider-conteudo');
const leftArrow = document.getElementById("seta-esquerda");
const rightArrow = document.getElementById("seta-direita");

// Declarar variáveis globais
let currentPage = 0;
let itensPerView = 1;
let autoSlideInterval;

// Criação/Organização do Carrossel

function updateCarrossel(){
    const sliderWidth = slider.offsetWidth;
    const itemWidth = sliderContent.children[0].getBoundingClientRect().width;

    itensPerView = (sliderWidth / itemWidth);
    totalPages = Math.ceil((sliderContent.children.length / itensPerView) - 2* ((sliderWidth/itemWidth)/100));
    
}

// MOVIMENTAÇÃO

function scrollToPage(){
    const cardWidth = sliderContent.children[0].getBoundingClientRect().width + 20;
    const newPosition = cardWidth * 3 * currentPage;
    sliderContent.scrollTo({left:newPosition, behavior: "smooth"});
}

function moveLeft(){
    currentPage--;
    if (currentPage < 0){
        currentPage = totalPages-1;
    }
    scrollToPage();
    resetAutoSlide();
}

function moveRight(){
    currentPage++;
    if (currentPage >= totalPages){
        currentPage = 0;
    }

    scrollToPage();
    resetAutoSlide();
}

//SLIDE AUTOMATICO

function startAutoSlide(){
    autoSlideInterval = setInterval( () => {
        moveRight();
    }, 10000)
}

function resetAutoSlide(){
    clearInterval(autoSlideInterval);
    startAutoSlide();
}

//EVENTOS

leftArrow.addEventListener('click', moveLeft);
rightArrow.addEventListener('click', moveRight);
window.addEventListener('resize', updateCarrossel);

//CHAMA ÍNICO DAS FUNÇÕES
updateCarrossel();
startAutoSlide();



// const fioPath = document.querySelector('.container-fio path');
// const itens = document.querySelectorAll('.item-fio');
// const secao = document.querySelector('.container-fio');

// const comprimento = fioPath.getTotalLength();
// fioPath.style.strokeDasharray = comprimento;
// fioPath.style.strokeDashoffset = comprimento;
// fioPath.style.transition = 'none';

// itens.forEach(item => {
//     item.style.opacity = '0';
//     item.style.transform = 'translateY(20px)';
//     item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
// });

// const limiares = [0.08, 0.2, 0.42, 0.58, 0.76];

// function animarScroll() {
//     const secaoRect = secao.getBoundingClientRect();
//const alturaTela = window.innerHeight;
//     const alturaTotalSecao = secaoRect.height;

//     const inicio = alturaTela - secaoRect.top;
//     const total = alturaTotalSecao + alturaTela;

//     const progresso = Math.min(Math.max(inicio / total, 0), 1);

//     fioPath.style.strokeDashoffset = comprimento - (comprimento * progresso);

//     itens.forEach((item, index) => {
//         const limiar = limiares[index] ?? (index / itens.length);

//         if (progresso >= limiar) {
//             item.style.opacity = '1';
//             item.style.transform = 'translateY(0)';
//         } else {
//             item.style.opacity = '0';
//             item.style.transform = 'translateY(20px)';
//         }
//     });
// }

// window.addEventListener('scroll', animarscroll);
// animarScroll();