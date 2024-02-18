document.addEventListener("DOMContentLoaded", () => {
    const iconMenu = document.querySelectorAll("nav .burger img");
    const menuActive = document.querySelectorAll(".menu-mobile");
    const burgerIcon = document.querySelector("nav .burger-icon ");
    const crossIcon = document.querySelector("nav .cross-icon");
    const allLinks = document.querySelectorAll("nav .menu-links ul li");

    iconMenu.forEach((icon) => {
        icon.addEventListener("click", () => {
            burgerIcon.classList.toggle("hidden");
            crossIcon.classList.toggle("hidden");
            menuActive.forEach((menu) => {
                menu.classList.toggle("active");
            });
            let delay = 0.4;
            const delayAdd = 0.2;
            allLinks.forEach((link) => {
                link.classList.toggle("fadeInUp");
                link.style.animationDelay = delay + "s";
                delay += delayAdd;
            });
        });
    })
});

