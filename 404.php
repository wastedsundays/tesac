<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tesac-curl
 */

get_header();
?>

	<main id="primary" class="error-page">

		<section class="error-404 not-found card-container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tesac-curl' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<img src="<?php echo get_template_directory_uri(); ?>/images/sad-curler.jpg" alt="404" class="error-image">
				<p><?php esc_html_e( 'That rock never crossed the hog line. Next round is on you' ); ?></p>

					

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
