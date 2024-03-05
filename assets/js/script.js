document.addEventListener("DOMContentLoaded", () => {

    //MOBILE MENU
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

    //MODAL
    const buttonsModal = document.querySelectorAll(".modal-link");
    const modal = document.querySelector(".modal-container");
    const refPhoto = document.querySelector(".reference");
    const inputRef = document.querySelector(".modal-container .input-ref input");

    buttonsModal.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.add("active");
            inputRef.value = refPhoto.textContent;
            inputRef.value = inputRef.value.toUpperCase();
            const buttonCloseModal = document.querySelector("footer .modal-container .close-modal-btn");
            buttonCloseModal.addEventListener("click", () => {
                document.querySelector("footer .modal-container").classList.remove("active");
            })
        });
    });

    //PAGE SINGLE - ARROW OPTIONS
    const leftArrow = document.querySelector(".arrow-left a");
    const rightArrow = document.querySelector(".arrow-right a");
    const leftArrowIcon = "&#x27F5";
    const rightArrowIcon = "&#x27F6";
    // mettre une condition en place concernant la présence des flèches pour éviter l'erreur dans la console pour le premier et dernier article
    if (leftArrow) {
        leftArrow.innerHTML = leftArrowIcon;
    }

    if (rightArrow) {
        rightArrow.innerHTML = rightArrowIcon;
    }

});

