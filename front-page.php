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

	<main id="primary" class="tesac-home">

		<?php
		while ( have_posts() ) :
			the_post();


			?>
			<div class="card-container welcome-card">

			<?php
				get_template_part( 'template-parts/content', 'page' );


			?>	
		</div>
		<div class="card-container condensed-standings-card">
		<?php
			echo do_shortcode('[condensed_standings]');
		?>
		</div>
		<div class="card-container upcoming-card">
		<?php
			echo do_shortcode('[upcoming_schedule]');
		?>
		</div>
		<div class="card-container results-card">
		<?php
			echo do_shortcode('[past_schedule]');
		?>
		</div>
		
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
