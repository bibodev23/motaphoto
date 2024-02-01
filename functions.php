<?php 

function theme_enqueue_styles() {
     //j'appelle mon fichier css
     wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array());
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function enqueue_script() {
    // j'appelle mon fichier js
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_script');

function register_my_menu() {
    //j'active le menu dans la page admin
    register_nav_menu( 'main-menu','Menu principal');
}
add_action( 'after_setup_theme', 'register_my_menu' );

add_theme_support('custom-logo');
