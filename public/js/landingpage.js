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

// ---------- ANIMAÇÃO DO FIO ----------

let svg = document.querySelector("svg");
let path = svg.querySelector("path");

const pathLength = path.getTotalLength();

console.log(pathLength);

gsap.set(path, { strokeDasharray: pathLength });

gsap.fromTo(
    path,
    {
        strokeDashoffset: pathLength,
    },
    {
        strokeDashoffset: 0,
        duration: 10,
        ease: "none",
        scrollTrigger:{
            trigger:".container-fio",
            start:"-10%",
            end:"bottom bottom",
            scrub:1,
        }
    }

);

gsap.utils.toArray(".item-fio").forEach((item) => {

    const itemTop = item.offsetTop;
    const containerHeight = document.querySelector(".container-fio").offsetHeight;
    
    const startPercent = (itemTop / containerHeight) * 100;

    gsap.fromTo(
        item,
        { opacity: 0},
        {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".container-fio",
                start: `${startPercent}% center`,
                toggleActions: "play none none reverse",
                scrub: false,
            }
        }
    );
});