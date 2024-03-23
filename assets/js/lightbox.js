//CREATION ARRAY LIGHTBOX EN GLOBAL POUR LE RECUPERER DANS LES FONCTIONS
let arrayLitghtbox = [];

//INITIALISATION DE LA FONCTION QUI MET A JOUR LE TABLEAU ARRAYLIGHTBOX
function updateArrayLitghtbox() {
    arrayLitghtbox = [];
    const lightboxLinks = document.querySelectorAll("main .icon-lightbox");
    lightboxLinks.forEach((link) => {
        arrayLitghtbox.push(link.dataset);
    })
};

//INITIALISATION DE LA FONCTION QUI ACTIVE LA LIGHTBOX
function initLighbox() {
    const lightboxLinks = document.querySelectorAll("main .icon-lightbox");
    const lightbox = document.querySelector(".lightbox");
    const lightboxImgUrl = document.querySelector(".lightbox .lightbox-image img");
    const lightboxReference = document.querySelector(".lightbox .reference");
    const lightboxCategory = document.querySelector(".lightbox .category");
    const previousArrow = document.querySelector(".lightbox-arrow-previous");
    const nextArrow = document.querySelector(".lightbox-arrow-next");
    const closeLightbox = document.querySelector(".lightbox .close-lightbox");
    //PARCOUR DES ICONES LIGHTBOX POUR Y AJOUTER UN EVENEMENT CLICK
    lightboxLinks.forEach((link, index) => {
        link.addEventListener("click", () => {
            //RECUPERATION DES INFOS DU POST POUR LA LIGHTBOX DEPUIS LE TABLEAU ARRAYLIGHTBOX
            let indexPhoto = index;
            lightboxImgUrl.src = arrayLitghtbox[indexPhoto].url;
            lightboxReference.textContent = arrayLitghtbox[indexPhoto].reference;
            lightboxCategory.textContent = arrayLitghtbox[indexPhoto].categorie;
            lightbox.classList.add("active");
            console.log(arrayLitghtbox.length);
            //GESTION DES ARROWS POUR LES POSTS SUIVANTS ET PRECEDENTS
            previousArrow.addEventListener("click", () => {
                if (indexPhoto > 0) {
                    indexPhoto--;
                    lightboxImgUrl.src = arrayLitghtbox[indexPhoto].url;
                    lightboxReference.textContent = arrayLitghtbox[indexPhoto].reference;
                    lightboxCategory.textContent = arrayLitghtbox[indexPhoto].categorie;
                }
            })
            nextArrow.addEventListener("click", () => {
                if (indexPhoto < arrayLitghtbox.length - 1) {
                    indexPhoto++;
                    lightboxImgUrl.src = arrayLitghtbox[indexPhoto].url;
                    lightboxReference.textContent = arrayLitghtbox[indexPhoto].reference;
                    lightboxCategory.textContent = arrayLitghtbox[indexPhoto].categorie;
                }
            })
            if (arrayLitghtbox.length <= 1) {
                const arrows = document.querySelectorAll(".arrow");
                arrows.forEach((arrow) => {
                    arrow.classList.add("hidden");
                })
            }
        })
    })
    closeLightbox.addEventListener("click", () => {
        lightbox.classList.remove("active");
    })
}

// CREATION DE WINDOW.LIGHTBOX POUR EXPORTER LES FONCTIONS
window.lightbox = {
    updateArrayLitghtbox: updateArrayLitghtbox,
    initLighbox: initLighbox,
};

// LANCEMENT DES FONCTIONS UNE FOIS LE DOM CHARGE
document.addEventListener("DOMContentLoaded", () => {
    updateArrayLitghtbox();
    initLighbox();
});