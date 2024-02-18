<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motaphoto</title>
    <?php wp_head(); ?>
</head>

<body>
    <nav class="menu-mobile">
        <div class="navbar">
            <div class="navbar-logo-burger">
                <div id="logo">
                    <?php
                    // j'active la fonction d'ajout de logo et appelle le menu par défaut de wordpress
                    if (function_exists('the_custom_logo')) {
                        the_custom_logo();
                    }
                    ?>
                </div>

                <div class="burger">
                    <img class="icon-menu burger-icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/burger_menu.png" alt="">
                    <img class="icon-menu cross-icon hidden" src="<?php echo get_template_directory_uri(); ?>/assets/img/close_menu.png" alt="">
                </div>
            </div>
            <div class="menu-mobile menu-links">
                <?php wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'container' => false
                )); ?>
            </div>


        </div>
    </nav>
    <main>