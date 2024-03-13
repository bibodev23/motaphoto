<?php 

function theme_enqueue_styles() {
     //j'appelle mon fichier css
     wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array());
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function enqueue_script() {
    // j'appelle mon fichier js
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js', ['jquery']);
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
        $items .= '<li><p class="modal-link">Contact</p></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_modal_link', 10, 2 );

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts()
{
    $idPostsDisplayed = explode(',', $_POST['idPostsDisplayed']);
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'post__not_in' => $idPostsDisplayed,
    );
    $my_query = new WP_Query($args);
    $data = [];
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            ob_start();
            get_template_part('templates_part/photo_block');
            $html_content = ob_get_clean();
            $data[] = $html_content;
        }
    }
    wp_reset_postdata();
    wp_send_json_success($data);
}

add_action('wp_ajax_filter', 'filter');
add_action('wp_ajax_nopriv_filter', 'filter');

function filter()
{
    $term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
    $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : '';

    if (isset($_POST['order'])) {
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 8,
            'order' => $order,
            'orderby' => 'date'
        );
    }
    else {
        if (empty($taxonomy) || empty($term)) {
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 8
            );
        } else {
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 8,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term
                    )       
                )
            );
        }
    }

    $my_query = new WP_Query($args);

    $data = [];

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            ob_start();
            get_template_part('templates_part/photo_block');
            $html_content = ob_get_clean();
            $data[] = $html_content;
        }
    }

    wp_reset_postdata();
    wp_send_json_success($data);
}