<?php 

function theme_enqueue_styles() {
     //j'appelle mon fichier css
     wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array());
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function enqueue_script() {
    // j'appelle mon fichier js
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js');
}
add_action('wp_enqueue_scripts', 'enqueue_script');

function register_my_menu() {
    //j'active le menu dans la page admin
    register_nav_menu( 'main-menu','Menu principal');
}
add_action( 'after_setup_theme', 'register_my_menu' );
    //j'ajoute l'option custom logo qui me permet d'intégrer mon logo depuis la page admin
add_theme_support('custom-logo');

    //Ajout du lien pour la modal
function add_modal_link( $items, $args ) {
    if ( $args->theme_location == 'main-menu' ) {
        $items .= '<li><a href="#" class="modal-link">Contact</a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_modal_link', 10, 2 );

