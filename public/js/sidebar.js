const body = document.querySelector("body"),
    sidebar = body.querySelector(".sidebar"),
    toggleLeft = body.querySelector(".toggle.left"),
    toggleRight = body.querySelector(".toggle.right");

    toggleLeft.addEventListener("click", () =>{
        sidebar.classList.add("close");
    });

    toggleRight.addEventListener("click", () =>{
        sidebar.classList.remove("close");
    });