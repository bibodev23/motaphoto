<?php
get_header() ?>

<div class="hero">
	<?php
	// 1. On définit les arguments pour définir ce que l'on souhaite récupérer
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => 1,
		//appliquer un ordre aléatoire
		'orderby' => 'rand',
	);

	// 2. On exécute la WP Query
	$my_query = new WP_Query($args);

	// 3. On lance la boucle !
	if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();

			// On affiche le contenu du template
			echo get_template_part('templates_part/photo_block');
	?>

	<?php
		endwhile;
	endif;

	// 4. On réinitialise à la requête principale (important)
	wp_reset_postdata();
	?>
</div>

<div class="home-container">
	<div class="filter-container">
		<div class="category-format-content">
			<?php
			$allTaxo = get_taxonomies(['_builtin' => false]);
			foreach ($allTaxo as $taxo) {

				$terms = get_terms($taxo);
				echo '<div class=" taxonomy ' . $taxo . '"data-taxonomy="' . $taxo . '" data-ajaxurl="' . admin_url('admin-ajax.php') . '">';
				switch ($taxo) {
					case 'categorie':
						$taxo = 'Catégories';
						break;
					case 'format':
						$taxo = 'Formats';
						break;
				}
				echo '<h3 class="title-taxo"> <span>' . $taxo . '</span><img src="' . get_template_directory_uri() . '/assets/img/arrow-down.svg" class="arrow-down"></h3>';
				echo '<ul>';
				foreach ($terms as $term) {
					echo '<li class="term-item">' . $term->name . '</li>';
				}
				echo '</div>';
			}
			?>
		</div>
		<div class="order-content">
			<div class="taxonomy order" data-taxonomy="order" data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>">
				<h3><span>Trier par</span> <img src=" <?php echo get_template_directory_uri() . '/assets/img/arrow-down.svg' ?>" class="arrow-down"></h3>
				<ul>
					<li data-order="DSC">À partir des plus récentes</li>
					<li data-order="ASC">À partir des plus anciennes</li>
				</ul>
			</div>

		</div>
	</div>

	<div class="home-list-photo">
		<?php
		// 1. On définit les arguments pour définir ce que l'on souhaite récupérer
		$args = array(
			'post_type' => 'photo',
			'posts_per_page' => 8,
		);

		// 2. On exécute la WP Query
		$my_query = new WP_Query($args);

		// 3. On lance la boucle !
		if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();

				// On affiche le contenu de la page
				echo get_template_part('templates_part/photo_block');
		?>

		<?php
			endwhile;

		endif;

		// 4. On réinitialise à la requête principale (important)
		wp_reset_postdata();
		?>
	</div>

	<div class="home-button-load-more">
		<button id="voir-plus" class="voir-plus" data-posts-per-page="8" data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>">Voir plus</button>
	</div>

</div>


<?php get_footer(); ?>