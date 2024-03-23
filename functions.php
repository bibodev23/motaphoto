<?php
//APPEL DU CSS ET DES SCRIPTS
function enqueue_scripts()
{
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array());
    wp_enqueue_script('lightbox-file', get_stylesheet_directory_uri() . '/assets/js/lightbox.js', array('jquery'), '1.1.0', false);
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0.0', false);
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'photo-block', 564, 495, true );
}
//ACTIVATION DU MENU DANS LA PAGE ADMIN
function register_my_menu()
{
    register_nav_menu('main-menu', 'Menu principal');
}
add_action('after_setup_theme', 'register_my_menu');

//ACTIVATION PRISE EN CHARGE DU CUSTOM LOGO
add_theme_support('custom-logo');


//INITIALISATION DE LA FONCTION AJAX
function get_posts_ajax($idPostsDisplayed = null) {
    //RECEPTION DES DONNEES DE L'UTILISATEUR
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : '';

    //INITIALISATION DES ARGUMENTS SELON LE CHOIX DE L'UTILISATEUR
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'post__not_in' => $idPostsDisplayed ?? [],
        'tax_query' => array(
            'relation' => 'AND'
        )
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }

    if (!empty($order)) {
        $args['order'] = $order;
    }
    //INITIALISATION DE CLASSE WP_QUERY POUR RECUPERER LES DONNES AVEC LES ARGUMENTS ENREGISTRES
    $my_query = new WP_Query($args);
    $data = [];
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            // Permet d'enregistrer le contenu dans le fichier tampon
            ob_start();
            get_template_part('templates_part/photo_block');
            //permet le nettoyage du résultat
            $html_content = ob_get_clean();
            $data[] = $html_content;
        }
    }
    wp_reset_postdata();
    //ENREGISTREMENT DES DONNES DANS LE TABLEAU DATA
    return $data;
}
function load_more_posts()
{
    $idPostsDisplayed = explode(',', $_POST['idPostsDisplayed']);
    //APPEL DE LA FONCTION AJAX
    $data = get_posts_ajax($idPostsDisplayed);
    //ENVOI DES DONNÉES
    wp_send_json_success($data);
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function filter()
{
    $data = get_posts_ajax();
    wp_send_json_success($data);
}
add_action('wp_ajax_filter', 'filter');
add_action('wp_ajax_nopriv_filter', 'filter');
