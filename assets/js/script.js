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
            modal.classList.toggle("active");
            inputRef.value = refPhoto ? refPhoto.textContent : "";
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

    //HOME PAGE BUTTON LOAD MORE
    jQuery(".voir-plus").click(function(e) {
        e.preventDefault();
        const posts = document.querySelectorAll(".home-list-photo .photo-block");
        const idPostsDisplayed = [];
        posts.forEach((post) => {
            console.log(post);
            console.log(post.id);
            idPostsDisplayed.push(post.id);
        });
        console.log(idPostsDisplayed);
        const ajaxurl = jQuery(this).data("ajaxurl");
        const data = {
            'action': 'load_more_posts',
            'idPostsDisplayed': idPostsDisplayed,
        };
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
            jQuery('.home-list-photo').append(data.data);
        }));
    })

    //HOME PAGE FILTER
    const allTaxonomy = document.querySelectorAll(".taxonomy");
    allTaxonomy.forEach(element => {
        const titleContainer = element.querySelector("h3");
        const titleText = titleContainer.querySelector("span");
        const initialText = titleText.textContent;
        console.log(initialText);
        const arrow = titleContainer.querySelector("img");
        const ul = element.querySelector("ul");
        titleContainer.addEventListener("click", () => {
            ul.classList.toggle("active");
            arrow.classList.toggle("active");
            titleContainer.classList.toggle("active");
        })
        const allTerm = element.querySelectorAll("ul li");
        const taxo = element.dataset.taxonomy;
        titleText.textContent = taxo;
        allTerm.forEach(term => {
            term.addEventListener("click", () => {
                ul.classList.toggle("active");
                titleContainer.classList.toggle("active");
                titleText.textContent = term.innerHTML;
                arrow.classList.toggle("active");
                const ajaxurl = element.dataset.ajaxurl;
                console.log(ajaxurl);
                console.log(taxo);
                console.log((term.innerHTML).toLowerCase());
                const data = term.dataset.order ? {
                    'action': 'filter',
                    'order': term.dataset.order,
                } : {
                    'action': 'filter',
                    'taxonomy': taxo,
                    'term': (term.innerHTML).toLowerCase(),
                }
                if (term.dataset.order) {
                    console.log(term.dataset.order);
                }
                console.log(data);
                
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Cache-Control': 'no-cache'
                    },
                    body: new URLSearchParams(data),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        jQuery('.home-list-photo').html(data.data)
                    });
            })
        })
    });
    
});

