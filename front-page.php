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

			// get_template_part( 'template-parts/content', 'page' );
			?>
			<div class="card-container">
			<h1>Welcome to TESAC</h1>
			<img src="https://cdn.prod.website-files.com/5d655866b2055c7cbb5d79a1/66b4f249a6af63cbaa044e9f_022823_MikeSchut059.jpg" alt="Curling">
			<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis modi qui libero doloribus eveniet? Voluptas modi eveniet ex, quibusdam quaerat expedita aliquam fugiat rerum perspiciatis est, ab nisi velit itaque.</p>
			
		</div>
		<div class="card-container">
		<?php
			echo do_shortcode('[condensed_standings]');
		?>
		</div>
		<div class="card-container">
		<?php
			echo do_shortcode('[upcoming_schedule]');
		?>
		</div>
		<div class="card-container">
		<?php
			echo do_shortcode('[upcoming_schedule]');
		?>
		</div>
		
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
