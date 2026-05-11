

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
    
    const startPercent = ((itemTop + 50) / containerHeight) * 100;

    gsap.fromTo(
        item,
        { opacity: 0},
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