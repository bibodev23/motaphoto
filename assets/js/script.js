document.addEventListener("DOMContentLoaded", () => {
    //RECUPERATION DES FONCTIONS DU FICHIER LIGHTBOX.JS
    let updateArrayLitghtbox = lightbox.updateArrayLitghtbox;
    let initLighbox = lightbox.initLighbox;
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
                //PARAMETRES DE L'ANIMATION D'APPARITION DE CHAQUE LI
                link.classList.toggle("fadeInUp");
                link.style.animationDelay = delay + "s";
                delay += delayAdd;
            });
        });
    })

    //MODAL
    const linkModalNavbar = document.getElementById("menu-item-90");
    linkModalNavbar.classList.add("modal-link")
    const buttonsModal = document.querySelectorAll(".modal-link");
    const modal = document.querySelector(".modal-container");
    const refPhoto = document.querySelector(".reference");
    const inputRef = document.querySelector(".modal-container .input-ref input");

    buttonsModal.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            modal.classList.toggle("active");
            if (button.classList.contains("menu-item-90")) {
                inputRef.value = "";
            } else {
                inputRef.value = refPhoto ? refPhoto.textContent : "";
            }

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
    //HOME PAGE FILTER
    const allTaxonomy = document.querySelectorAll(".taxonomy");
    let filterCategoryValue = "";
    let filterFormatValue = "";
    let filterOrderValue = "";
    let data = {};
    allTaxonomy.forEach(element => {
        const titleContainer = element.querySelector("h3");
        const titleText = titleContainer.querySelector("span");
        const arrow = titleContainer.querySelector("img");
        const ul = element.querySelector("ul");
        titleContainer.addEventListener("click", () => {
            ul.classList.toggle("active");
            arrow.classList.toggle("active");
            titleContainer.classList.toggle("active");

        });
        const allTerm = element.querySelectorAll("ul li");
        const taxo = element.dataset.taxonomy;
        titleText.textContent = taxo;
        allTerm.forEach(term => {
            term.addEventListener("click", () => {
                jQuery(".voir-plus").css("display", "block");
                ul.classList.toggle("active");
                titleContainer.classList.toggle("active");
                titleText.textContent = term.innerHTML;
                arrow.classList.toggle("active");
                //GESTION DES VARIABLE SELON LE CHOIX DE L'UTILISATEUR
                switch (taxo) {
                    case 'categorie':
                        if (term.classList.contains("all")) {
                            titleText.textContent = taxo;
                            filterCategoryValue = "";
                        } else {
                            filterCategoryValue = (term.textContent).toLowerCase();
                        }
                        break;
                    case 'format':
                        if (term.classList.contains("all")) {
                            titleText.textContent = taxo;
                            filterFormatValue = "";
                        } else {
                            filterFormatValue = (term.textContent).toLowerCase();
                        }
                        break;

                    case 'order':
                        filterOrderValue = term.dataset.order;
                        break;
                    default:
                        break;
                }
                const ajaxurl = element.dataset.ajaxurl;
                //PARAMETRAGE DE L'OBJET DATA POUR L'AJAX
                data = {
                    'action': 'filter',
                    'category': filterCategoryValue,
                    'format': filterFormatValue,
                    'order': filterOrderValue,
                }
                //INITIALISATION DE L'AJAX
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Cache-Control': 'no-cache'
                    },
                    //INCLUSION DE L'OBJET DATA
                    body: new URLSearchParams(data),
                })
                    //RECUPERATION DES DONNEES
                    .then(response => response.json())
                    .then(data => {
                        jQuery('.home-list-photo').html(data.data);
                        updateArrayLitghtbox();
                        initLighbox();
                    });
            })
        })
    });

    //HOME PAGE BUTTON LOAD MORE
    jQuery(".voir-plus").click(function (e) {
        e.preventDefault();
        const posts = document.querySelectorAll(".home-list-photo .photo-block");
        const idPostsDisplayed = [];
        posts.forEach((post) => {
            idPostsDisplayed.push(post.id);
        });
        const ajaxurl = jQuery(this).data("ajaxurl");
        data = {
            'action': 'load_more_posts',
            'category': filterCategoryValue,
            'format': filterFormatValue,
            'order': filterOrderValue,
            'idPostsDisplayed': idPostsDisplayed
        }
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            },
            body: new URLSearchParams(data),
        })
            .then(response => response.json()
                .then(data => {
                    console.log(data.data.length);
                    if (data.data.length === 0) {
                        jQuery(".voir-plus").css("display", "none");
                    }
                    jQuery('.home-list-photo').append(data.data);
                    updateArrayLitghtbox();
                    initLighbox();
                }));
    })
});

