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

	<main id="primary" class="schedule-page">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );



			$args = array(
				'post_type' => 'schedule',
				'posts_per_page' => -1, 
				'orderby' => 'date',
				'order' => 'ASC' 
			);
			$query = new WP_Query( $args );
			

			$upcoming_draws = array();
			$past_draws = array();
			

			if ( $query->have_posts() ) :
			
	
				while ( $query->have_posts() ) : $query->the_post();
					
	
					$date = get_field('date');
					$formatted_date = date('F j, Y g:i a', strtotime($date));
					

					$current_date = current_time('Y-m-d H:i:s'); // Get current time in proper format
					$post_date = get_field('date'); 
					

					if (strtotime($post_date) < strtotime($current_date)) {

						$past_draws[] = array(
							'title' => get_the_title(),
							'formatted_date' => $formatted_date,
							'class' => 'previous-draw'
						);
					} else {

						$upcoming_draws[] = array(
							'title' => get_the_title(),
							'formatted_date' => $formatted_date,
							'class' => 'upcoming-draw'
						);
					}
			
				endwhile;

				
			
				// upcoming draws
				if (!empty($upcoming_draws)) {
					foreach ($upcoming_draws as $draw) {
						?>
						<div class="schedule-post card-container <?php echo $draw['class']; ?>">
							<h2><?php echo $draw['title']; ?></h2>
							<p class="schedule-date-time"><?php echo $draw['formatted_date']; ?></p>
						</div>
						<?php
					}
				}
			
				// Past draws
				if (!empty($past_draws)) {
					foreach ($past_draws as $draw) {
						?>
						<div class="schedule-post card-container <?php echo $draw['class']; ?>">
							<h2><?php echo $draw['title']; ?></h2>
							<p class="schedule-date-time"><?php echo $draw['formatted_date']; ?></p>
						</div>
						<?php
					}
				}
			
				// Reset post data after the loop
				wp_reset_postdata();
			
			else :
				echo 'No schedule posts found.';
			endif;

			

			

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_footer();
