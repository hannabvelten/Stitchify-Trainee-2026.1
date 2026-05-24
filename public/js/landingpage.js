// ---------- ANIMAÇÃO DO FIO - Responsivo ----------

gsap.registerPlugin(ScrollTrigger);

const isMobile = window.innerWidth <= 767;
const svg = document.querySelector(isMobile ? ".svg-mobile" : ".svg-desktop");
const path = svg.querySelector("path");

const pathLength = path.getTotalLength();

gsap.set(path, {
    strokeDasharray: pathLength,
    strokeDashoffset: pathLength
});

gsap.fromTo(
    path,
    { strokeDashoffset: pathLength },
    {
        strokeDashoffset: 0,
        duration: 10,
        ease: "none",
        scrollTrigger: {
            trigger: ".container-fio",
            start: "-10%",
            end: "bottom bottom",
            scrub: 1,
        }
    }
);

gsap.set(".item-fio", { opacity: 0 });

gsap.utils.toArray(".item-fio").forEach((item) => {

    if (getComputedStyle(item).display === "none") return;

    const containerEl = document.querySelector(".container-fio");
    const containerRect = containerEl.getBoundingClientRect();
    const itemRect = item.getBoundingClientRect();

    const itemRelativeTop = itemRect.top - containerRect.top;
    const containerHeight = containerEl.offsetHeight;

    const startPercent = ((itemRelativeTop) / containerHeight) * 100;

    gsap.fromTo(
        item,
        { opacity: 0, y: 20 },
        {
            opacity: 1,
            y: 0,
            duration: 1,
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


// === Carrossel Cards Blog - Responsivo ===

const slider = document.querySelector('.cards-blog');
const sliderContent = document.querySelector('.slider-conteudo');
const leftArrow = document.getElementById("seta-esquerda");
const rightArrow = document.getElementById("seta-direita");

let currentPage = 0;
let itensPerView = 3;
let totalPages = 1;
let autoSlideInterval;

// Aqui vai definir quantos itens vao aparecer por vez em diferentes dispositivos
function getItensPerView() {
    if (window.innerWidth <= 767) return 1;       
    if (window.innerWidth <= 1200) return 2;      
    return 3;                                      
}

function updateCarrossel() {
    itensPerView = getItensPerView();
    totalPages = Math.ceil(sliderContent.children.length / itensPerView);
    currentPage = 0;
    sliderContent.scrollLeft = 0;
}

function scrollToPage() {
    const pageWidth = sliderContent.offsetWidth;
    sliderContent.scrollTo({ left: currentPage * pageWidth, behavior: 'smooth' });
    resetAutoSlide();
}

function moveLeft() {
    currentPage--;
    if (currentPage < 0) currentPage = totalPages - 1;
    scrollToPage();
    resetAutoSlide();
}

function moveRight() {
    currentPage++;
    if (currentPage >= totalPages) currentPage = 0;
    scrollToPage();
    resetAutoSlide();
}

function startAutoSlide() {
    autoSlideInterval = setInterval(() => moveRight(), 5000);
}

function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
}

leftArrow.addEventListener('click', moveLeft);
rightArrow.addEventListener('click', moveRight);
window.addEventListener('resize', updateCarrossel);

updateCarrossel();
startAutoSlide();