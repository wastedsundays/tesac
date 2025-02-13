<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tesac-curl
 */

get_header();
?>

	<main id="primary" class="teams-page">

		<?php
		while ( have_posts() ) :
			the_post();

			$currentSeason = 'winter-2025'; // Default season

			$args = array(
				'post_type' => 'teams', 
				'tax_query' => array(
					array(
						'taxonomy' => 'season', 
						'field'    => 'slug', 
						'terms'    => $currentSeason, 
						'operator' => 'IN',

					),
				),
				'posts_per_page' => -1, 
				'orderby' => 'ID', 
				'order' => 'ASC',
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) :
				$terms = get_terms( array(
					'taxonomy' => 'season',
					'slug' => $currentSeason,
					'fields' => 'names',
					) );

					if (!empty($terms)) {
						echo '<h1 class="grid-title">'. esc_html($terms[0]) . '</h1>';
					}
				while ( $query->have_posts() ) : $query->the_post();
					// Output the content of each post
					echo '<a href="' . get_permalink() . '">';
						echo '<div class="card-container">';

							echo '<p>' . get_the_title() . '</p>';
							the_excerpt();

						echo '</div>';
					echo '</a>';

				endwhile;
				wp_reset_postdata(); // Reset post data after the loop
			else :
				echo 'No teams found for ' . esc_html($terms[0])  . ' season.';
			endif;


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
