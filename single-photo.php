<?php
get_header();

while (have_posts()) : the_post();
	$post_id = get_the_ID();
	$acf_image = get_field('fichier_image');
	$acf_reference = get_field('reference_photo');
	$acf_categorie = get_the_terms($post_id, 'categorie')[0]->slug;
	$acf_cat = get_the_terms($post_id, 'categorie');
	$acf_format = get_the_terms($post_id, 'format')[0]->slug;
	$acf_type = get_field('type_photo');
	$acf_annee = get_field('annee_photo');
	if (get_previous_post()) {
		$prevPost = get_previous_post()->ID;
		$prev_acf_img = get_field('fichier_image', $prevPost);
	}

	if (get_next_post()) {
		$nextPost = get_next_post()->ID;
		$next_acf_img = get_field('fichier_image', $nextPost);
	}
?>
	<div class="single-photo-container">
		<div class="photo-content" id="<?php echo $post_id; ?>">
			<div class="photo-infos">
				<div class="infos-content">
					<h2 id="photo-title"><?php echo the_title(); ?></h2>
					<p>Référence : <span class="reference"><?php echo $acf_reference; ?></span></p>
					<p>Categorie : <?php echo $acf_categorie; ?></p>
					<p>Format : <?php echo $acf_format; ?></p>
					<p>Type : <?php echo $acf_type; ?></p>
					<p>Anneée : <?php echo $acf_annee; ?></p>
				</div>
			</div>
			<div class="photo-image">
				<img src="<?php echo $acf_image['url']; ?>" alt="">
			</div>
		</div>
		<div class="photo-options">
			<div class="option-contact">
				<p>Cette photo vous intéresse ?</p>
				<button class="modal-link">Contact</button>
			</div>
			<div class="option-arrow">
				<div class="arrows">
					<p class="arrow-left arrow"><?php previous_post_link('%link'); ?></p>
					<img src="<?php echo $prev_acf_img['url']; ?>" alt="">

					<p class="arrow-right arrow"><?php next_post_link('%link'); ?></p>
					<img src="<?php echo $next_acf_img['url']; ?>" alt="">

				</div>
			</div>
		</div>
	</div>
	<div class="photo-add-container">

		<h3>Vous aimerez aussi</h3>

		<div class="block-container">
			<?php
			$args = array(
				'post_type' => 'photo',
				'posts_per_page' => 2,
				'taxonomy' => 'categorie',
				'term' => $acf_categorie,
				'orderby' => 'rand',
			);
			$my_query = new WP_Query($args);
			if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
					echo get_template_part('templates_part/photo_block');
			?>
			<?php
				endwhile;
			endif;
			wp_reset_postdata();
			?>
		</div>

	</div>

<?php
endwhile;

get_footer();
