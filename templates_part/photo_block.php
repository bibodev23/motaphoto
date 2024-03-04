<?php $acf_image = get_field('fichier_image'); ?>
<div class="photo-block" id="<?php echo get_the_ID();?>">
    <a href="<?php the_permalink(); ?>"><img src="<?php echo $acf_image['url']; ?>" alt=""></a>
</div>