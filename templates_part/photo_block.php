<?php
$post_id = get_the_ID();
$acf_image = get_field('fichier_image');
$acf_reference = get_field('reference_photo');
$acf_categorie = get_the_terms($post_id, 'categorie')[0]->slug;
$acf_format = get_the_terms($post_id, 'format')[0]->slug;
?>

<div class="photo-block" id="<?php echo $post_id; ?>">
    <a href="<?php the_permalink(); ?>" aria-label="<?php echo $acf_categorie; ?>" ><img src="<?php echo $acf_image['url']; ?>" alt=""></a>
    <div class="photo-block-hover">
        <span class="icon-lightbox" data-url="<?php echo $acf_image['url']; ?>" data-reference="<?php echo $acf_reference; ?>" data-categorie="<?php echo $acf_categorie; ?>" data-format="<?php echo $acf_format; ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/icon_fullscreen.png' ?>" alt="fullscreen"></span>
        <a href="<?php the_permalink(); ?>"><img class="icon-more-info" src="<?php echo get_template_directory_uri() . '/assets/img/icon_eye.png' ?>" aria-label="Plus d'informations"></a>
        <div class="photo-info">
            <a href="<?php the_permalink(); ?>">
                <p><span class="reference"><?php echo $acf_reference; ?></span></p>
            </a>
            <a href="<?php the_permalink(); ?>">
                <p class="category"><?php echo $acf_categorie; ?></p>
            </a>
        </div>
    </div>
</div>