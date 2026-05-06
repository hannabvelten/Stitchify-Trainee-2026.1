// Passando elementos HTML para variavies JavaScript
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