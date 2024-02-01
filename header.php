<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motaphoto</title>
    <?php wp_head(); ?>
</head>

<body>
    <nav>
        <div id="logo">
        <?php
        // j'active la fonction d'ajout de logo et appelle le menu par défaut de wordpress
        if (function_exists('the_custom_logo')) {
            the_custom_logo();
        }
        ?>
        </div>
        
        <div id="menu-links">
        <?php wp_nav_menu(array('theme_location' => 'main-menu',)); ?>
        </div>
        
    </nav>